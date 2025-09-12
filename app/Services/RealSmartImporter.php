<?php

namespace App\Services;

use App\Models\Agency;
use App\Models\Property;
use App\Models\PropertyFloor;
use App\Models\PropertyRoom;
use App\Models\PropertyImage;
use App\Models\PropertyFloorPlan;
use App\Models\PropertyImage360;
// use App\Models\SystemLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Exception;

class RealSmartImporter
{
    public function import(): void
    {
        $agencies = Agency::where('enable_real_smart_importer', true)->get();

        if ($agencies->isEmpty()) {
            info('No agencies found with real smart importer enabled.');
            return;
        }

        foreach ($agencies as $agency) {
            if (!$agency->real_smart_xml_url || !$agency->id_user_owner) {
                continue;
            }

            try {
                $xmlString = Http::retry(3, 500) // fino a 3 tentativi
                    ->timeout(10)                // max 10 secondi
                    ->get($agency->real_smart_xml_url)
                    ->throw()                    // se non è 200, lancia eccezione
                    ->body();

                libxml_use_internal_errors(true);
                $data = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);

                if ($data === false) {
                    throw new \Exception("Errore parsing XML: " . collect(libxml_get_errors())->pluck('message')->join(', '));
                }

                $properties = $data->immobili->immobile; 

                foreach ($properties as $key => $single) {
                    $this->importSingleProperty($single, $agency);
                }

                if ($agency->real_smart_remove_after_delete) {
                    $this->removeDeletedProperties($agency, $properties);
                }

            } catch (\Throwable $e) {

                dd($e);
                // \Log::error("Errore import RealSmart: " . $e->getMessage(), [
                //     'agency_id' => $agency->id ?? null,
                // ]);
            }
        }
    }

    private function importSingleProperty($single, Agency $agency): void
    {

        $property = Property::where('real_smart_id', (string) $single->Codice)
            ->where('imported_from', 'realsmart')
            ->first();
    

        $isNew = !$property;

        if (!$property) {
            $property = new Property();
            $property->uuid = Str::uuid();
            $property->created_at = now();
        }

        $property->updated_at = now();
        $property->imported_from = 'realsmart';
        $property->id_agency = $agency->id;
        $property->id_owner = $agency->id_user_owner;
        $property->real_smart_id = (string) $single->Codice;
        $property->name = (string) $single->Titolo;
        $property->description = (string) $single->AnnuncioCompleto;
        $property->price = (float) $single->Costo;
        $property->country = 'Italy';
        $property->zip_code = (string) $single->CAP;
        $property->city = (string) $single->Comune;
        $property->area = (string) $single->Zona;
        $property->address = (string) $single->Indirizzo;
        $property->longitude = (float) $single->Lng;
        $property->latitude = (float) $single->Lat;
        $property->size = (int) $single->Mq;
        $property->year_production = (int) $single->AnnoCostruzione;
        $property->condominium_fees = (string) $single->SpeseCondominiali;
        $property->elevator = ((string) $single->Ascensore) === 'Si';
        $property->garden = ((string) $single->Giardino) === 'Si';
        $property->parking = ((string) $single->PostoAuto) === 'Si';
        $property->box = ((string) $single->Box) === 'Si';
        $property->air_conditioning = ((string) $single->AriaCondizionata) === 'Si';
        $property->ape = (string) $single->ACE;
        $property->contract = ((string) $single->Contratto) === 'Vendita' ? 'sale' : 'rent';
        $property->n_room = (int) $single->Camere;
        $property->n_bathroom = (int) $single->Bagni;
        $property->type = ((int) $single->CategoriaImmobile) === 1 ? 'residential' : 'commercial';
        $property->independent = true;

        $categoryMap = [
            'Appartamento' => 'apartment',
            'Attività' => 'commercial-space',
            'Box' => 'garage',
            'Mansarda' => '',
            'Negozio' => 'shop',
            'Terreno' => 'agricultural-land',
            'Ufficio' => 'office',
            'Villa' => 'villa',
            'Villino' => 'cottage',
        ];

        $property->category = $categoryMap[(string) $single->Tipologia] ?? null;

        $statusMap = [
            'Libero' => 'vacant',
            'Occupato' => 'occupied',
        ];
        $property->occupancy_status = $statusMap[(string) $single->StatoOccupazione] ?? null;

        $internalStatusMap = [
            'Nuovo' => 'new', 
            'Ristrutturato' => 'renovated',
            'Buono' => 'good',
            'Ottimo Stato' => 'excellent',
            'Originale' => 'original', 
            'Discreto' => 'fair',
            'Da Ristrutturare' => 'to_be_renovated',
        ];
        $property->internal_condition = $internalStatusMap[(string) $single->StatoInterno] ?? null;

        $property->save();


        // IMMAGINI (solo se nuove)
        if ($isNew || $property->images()->count() === 0) {
            foreach ($single->ElencoFoto->Foto ?? [] as $imageUrl) {
                $path = $this->downloadAndStoreImage((string) $imageUrl, 'properties_images');

                if($path){
                    $img = new PropertyImage();
                    $img->id_property = $property->id;
                    $img->path = $path;
                    $img->save();
                }
            }
        }

        // IMMAGINI 360
        if ($isNew || $property->images360()->count() === 0) {
            foreach ($single->ElencoFoto360->Foto360 ?? [] as $img360Url) {
                $path = $this->downloadAndStoreImage((string) $img360Url, 'properties_360_images');

                if($path){
                    $img = new PropertyImage360();
                    $img->id_property = $property->id;
                    $img->path = $path;
                    $img->save();
                }
            }
        }

        // PLANIMETRIE
        if ($isNew || $property->floorPlans()->count() === 0) {

            // controllo se ho un piano
            $floor = PropertyFloor::where("id_property", $property->id)->first();
            if(!$floor){
                $floor = new PropertyFloor;
                $floor->id_property = $property->id;
                $floor->save();
            }

            foreach ([$single->Planimetria, $single->Planimetria2] as $planUrl) {
                if ($planUrl) {
                    $path = $this->downloadAndStoreImage((string) $planUrl, 'properties_floor_plans');
                    
                    if($path){
                        $img = new PropertyFloorPlan();
                        $img->id_property = $property->id;
                        $img->id_property_floor = $floor->id;
                        $img->path = $path;
                        $img->save();
                    }
                }
            }
        }
    }

    private function downloadAndStoreImage(string $url, string $directory)
    {
        try {
            $response = Http::get($url);
            if (!$response->successful()) return;

            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $filename = Str::uuid() . '.' . $ext;

            Storage::disk('public')->put("{$directory}/{$filename}", $response->body());

            return $filename;

        } catch (Exception $e) {
            \Log::error("Error saving image {$url}: " . $e->getMessage());
        }
    }

    private function removeDeletedProperties(Agency $agency, $propertiesXml): void
    {
        $newIds = collect($propertiesXml)->map(fn($p) => (string) $p->Codice);

        $toDelete = Property::where('id_agency', $agency->id)
            ->where('imported_from', 'realsmart')
            ->whereNotIn('real_smart_id', $newIds)
            ->get();

        foreach ($toDelete as $property) {
            foreach ($property->images as $img) {
                Storage::disk('public')->delete($img->path);
            }
            foreach ($property->images360 as $img) {
                Storage::disk('public')->delete($img->path);
            }
            foreach ($property->floorPlans as $plan) {
                Storage::disk('public')->delete($plan->path);
            }
            $property->images()->delete();
            $property->images360()->delete();
            $property->floorPlans()->delete();
            $property->delete();
        }
    }
}
