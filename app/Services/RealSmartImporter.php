<?php

namespace App\Services;

use App\Models\Agency;
use App\Models\Property;
use App\Models\PropertyFloor;
use App\Models\PropertyRoom;
use App\Models\PropertyImage;
use App\Models\PropertyFloorPlan;
use App\Models\PropertyImage360;
use App\Models\User;
use App\Models\Log;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Exception;

class RealSmartImporter
{
    public function import(): void
    {
        $agencies = Agency::where('enable_real_smart_importer', true)->get();

        foreach ($agencies as $agency) {
            if (!$agency->real_smart_xml_url) {
                continue;
            }

            Log::new('Real estate imports from "'.$agency->name.'" have begun.');

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
                Log::new('Error importing "'.$agency->name.'" from Real Smart \n'.$e->getMessage(), 'error');
            }
        }
    }

    public function importSingleProperty($single, Agency $agency): void
    {

        try{
            $property = Property::where('real_smart_id', (string) $single->Codice)
                ->where('imported_from', 'realsmart')
                ->first();
        

            $isNew = !$property;

            if (!$property) {
                $property = new Property();
                $property->uuid = Str::uuid();
                $property->created_at = now();
                $property->id_owner = User::first()->id;
                $property->imported_from = 'realsmart';
            }

            $property->updated_at = now();
            $property->id_agency = $agency->id;
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
                'Mansarda' => 'apartment',
                'Negozio' => 'shop',
                'Terreno' => 'agricultural-land',
                'Ufficio' => 'office',
                'Villa' => 'villa',
                'Villino' => 'cottage',
            ];

            $property->category = $categoryMap[(string) $single->Tipologia] ?? 'apartment';

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

            $this->updateMedia($single, $property);
            
        }catch (\Throwable $e) {
            Log::new('Error importing property "'.$single->Codice.'" "'.$agency->name.'" from Real Smart \n'.$e->getMessage(), 'error');
        }
    }

    private function updateMedia($single, $property) {
        // IMMAGINI
        $incomingImageUrls = [];
        foreach ($single->ElencoFoto->Foto ?? [] as $imageUrl) {
            $incomingImageUrls[] = (string) $imageUrl;
        }

        $existingImages = $property->images(); 
        $existingImageUrls = $existingImages->pluck('original_url')->toArray();

        // Elimina le immagini non più presenti 
        foreach ($existingImages as $existingImage) {
            if (!in_array($existingImage->original_url, $incomingImageUrls)) {
                $existingImage->delete(); 
            }
        }

        // Scarica e salva solo le NUOVE immagini
        foreach ($incomingImageUrls as $url) {
            if (!in_array($url, $existingImageUrls)) {
                $path = $this->downloadAndStoreImage($url, 'properties_images');

                if ($path) {
                    $img = new PropertyImage();
                    $img->id_property = $property->id;
                    $img->path = $path;
                    $img->original_url = $url;
                    $img->save();
                }
            }
        }

        $this->removeDuplicateEntries($property->images());

        // IMMAGINI 360
        $incoming360Urls = [];
        foreach ($single->ElencoFoto360->Foto360 ?? [] as $img360Url) {
            $incoming360Urls[] = (string) $img360Url;
        }

        $existing360Images = $property->images360();
        $existing360Urls = $existing360Images->pluck('original_url')->toArray();

        foreach ($existing360Images as $existing360Image) {
            if (!in_array($existing360Image->original_url, $incoming360Urls)) {
                $existing360Image->delete();
            }
        }

        foreach ($incoming360Urls as $url) {
            if (!in_array($url, $existing360Urls)) {
                $path = $this->downloadAndStoreImage($url, 'properties_360_images');

                if ($path) {
                    $img = new PropertyImage360();
                    $img->id_property = $property->id;
                    $img->path = $path;
                    $img->original_url = $url;
                    $img->save();
                }
            }
        }

        $this->removeDuplicateEntries($property->images360());

        // PLANIMETRIE
        $incomingPlanUrls = [];
        foreach ([$single->Planimetria, $single->Planimetria2] as $planUrl) {
            if (!empty($planUrl)) {
                $incomingPlanUrls[] = (string) $planUrl;
            }
        }

        $existingPlans = $property->floorPlans();
        $existingPlanUrls = $existingPlans->pluck('original_url')->toArray();

        foreach ($existingPlans as $existingPlan) {
            if (!in_array($existingPlan->original_url, $incomingPlanUrls)) {
                $existingPlan->delete();
            }
        }

        $newPlanUrls = array_diff($incomingPlanUrls, $existingPlanUrls);

        if (!empty($newPlanUrls)) {
            
            $floor = PropertyFloor::where("id_property", $property->id)->first();
            if (!$floor) {
                $floor = new PropertyFloor;
                $floor->id_property = $property->id;
                $floor->save();
            }

            foreach ($newPlanUrls as $url) {
                $path = $this->downloadAndStoreImage($url, 'properties_floor_plans');
                
                if ($path) {
                    $img = new PropertyFloorPlan();
                    $img->id_property = $property->id;
                    $img->id_property_floor = $floor->id;
                    $img->path = $path;
                    $img->original_url = $url;
                    $img->save();
                }
            }
        }
    }

    private function removeDuplicateEntries($relation) {
        // Raggruppa i record per original_url e conta quanti ce ne sono
        $duplicates = $relation->get()->groupBy('original_url')->filter(function ($group) {
            return $group->count() > 1;
        });

        foreach ($duplicates as $url => $items) {
            // Mantieni il primo record e prendi gli altri per l'eliminazione
            $toDelete = $items->slice(1); 
            foreach ($toDelete as $model) {
                $model->delete();
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
            // Log::new("Error saving image {$url} from Real Smart \n".$e->getMessage(), "error"); 
        }
    }

    private function removeDeletedProperties(Agency $agency, $properties): void
    {
        // $newIds = collect($propertiesXml)->map(fn($p) => (string) $p->Codice)->toArray();

        $newIds = [];

        foreach ($properties as $single) {
            $newIds[] = strval($single->Codice);
        }

        $toDelete = Property::where('id_agency', $agency->id)
            ->where('imported_from', 'realsmart')
            ->whereNotIn('real_smart_id', $newIds)
            ->get();

        foreach ($toDelete as $property) {
            $property->delete();
        }
    }
}
