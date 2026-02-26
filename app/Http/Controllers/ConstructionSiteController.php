<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\BrevoMailer;

use App\Models\User;
use App\Models\EmailVerifyToken;
use App\Models\Agency;
use App\Models\Property;
use App\Models\WebsiteEmail;
use App\Models\ConstructionSite;
use App\Models\ConstructionSiteUnit;
use App\Models\ConstructionSiteImage;
use App\Models\ConstructionSiteDocument;

class ConstructionSiteController extends Controller
{
    public function showNew($agencyUuid){
        $construction = new ConstructionSite();
        $title = "Nuovo cantiere";

        $documents = [];

        return view("dash.constructionSites.new.show", compact("construction", "title", "documents"));
    }

    public function showEdit($agencyUuid, $siteUuid){
        
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();
        if(!$construction || $construction->id_agency != $agency->id){
            return;
        }

        $documents = ConstructionSiteDocument::where("id_construction_site", $construction->id)->get();

        $title = "Modifica ".$construction->name;

        return view("dash.constructionSites.new.show", compact("construction", "title", "documents"));
    }

    public function new($agencyUuid, Request $request){
        $agency = Agency::where("uuid", $agencyUuid)->first();

        if(!$agency){
            return false;
        }

        $site = new ConstructionSite();
        $site->id_agency = $agency->id;
        $site->id_owner = Auth::user()->id;

        $this->insertData($site, $request);
        
        $site->save();

        $this->insertDocument($site, $request);

        return redirect()->route("site:units", ['siteUuid' => $site->uuid, "agencyUuid" => $agencyUuid]);
    }   

    public function edit($agencyUuid, $siteUuid, Request $request){
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();
        if(!$construction || $construction->id_agency != $agency->id){
            return;
        }

        $this->insertData($construction, $request);
        
        $construction->save();

        $this->insertDocument($construction, $request);
        
        return redirect()->route("site:units", ['siteUuid' => $construction->uuid, "agencyUuid" => $agencyUuid]);
    }

    private function insertData($site, $request){
        // general
        $site->name =                       $request->input("name");
        $site->description =                $request->input("description");
        // $site->start_date =                 $request->input("start_date");
        // $site->completion_date =            $request->input("end_date");

        // description
        $site->country =                    "it";
        $site->address =                    $request->input("address");
        $site->city =                       $request->input("city");
        $site->province =                   $request->input("province");
        $site->area =                       $request->input("area");
        $site->zip_code =                   $request->input("zip_code");
        $site->latitude =                   $request->input("lat");
        $site->longitude =                  $request->input("lng");
    }

    private function insertDocument($site, $request){
        // elimino i documenti che mi inidica il frontEnd
        if ($request->filled('documents_to_delete')) {
            $docsToDelete = $request->input('documents_to_delete');
            
            $documents = ConstructionSiteDocument::whereIn('id', $docsToDelete)
                ->where("id_construction_site", $site->id)
                ->get();

            foreach ($documents as $document) {
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                $document->delete();
            }
        }

        // CARICAMENTO DEI NUOVI FILE
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('construction_sites/documents', 'public');

                $document = new ConstructionSiteDocument();
                $document->id_construction_site = $site->id;
                $document->path = $path;
                $document->name = $file->getClientOriginalName();
                $document->ext= $file->getClientOriginalExtension();
                
                $document->save();
            }
        }
    }

    public function showUnits($agencyUuid, $siteUuid){
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();
        if(!$construction || $construction->id_agency != $agency->id){
            return;
        }

        $units = ConstructionSiteUnit::with('firstImage')
            ->where("id_construction_site", $construction->id)
            ->get();
            
        return view("dash.constructionSites.new.showUnits", compact("construction", "agency", "units"));
    }

    public function showNewUnit($agencyUuid, $siteUuid){
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();
        if(!$construction || $construction->id_agency != $agency->id){
            return;
        }

        $unit = new ConstructionSiteUnit();

        return view("dash.constructionSites.new.showUnit", compact("construction", "agency", "unit"));
    }

    public function showEditUnit($agencyUuid, $siteUuid, $uuidUnit){
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $unit = ConstructionSiteUnit::where("uuid", $uuidUnit)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();

        if(!$construction || $construction->id_agency != $agency->id || $unit->id_construction_site != $construction->id){
            dd("Errore");
            return;
        }

        $images = ConstructionSiteImage::where("id_construction_site_unit", $unit->id)->get();

        return view("dash.constructionSites.new.showUnit", compact("construction", "agency", "unit", "images"));
    }

    public function newUnit($agencyUuid, $siteUuid, Request $request){
        
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();

        if(!$construction || $construction->id_agency != $agency->id){
            dd("Errore");
            return;
        }

        $unit = new ConstructionSiteUnit();
        $unit->id_construction_site = $construction->id;

        $this->insertUnitData($request, $unit);

        $unit->save();

        $this->insertImages($request, $unit, $construction->id);

        return redirect()->route("site:units", ['siteUuid' => $construction->uuid, "agencyUuid" => $agencyUuid]);
    }

    public function editUnit($agencyUuid, $siteUuid, $uuidUnit, Request $request){
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $unit = ConstructionSiteUnit::where("uuid", $uuidUnit)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();

        if(!$construction || $construction->id_agency != $agency->id || $unit->id_construction_site != $construction->id){
            return;
        }

        $this->insertUnitData($request, $unit);
        
        $unit->save();

        $this->insertImages($request, $unit, $construction->id);

        return redirect()->route("site:units", ['siteUuid' => $construction->uuid, "agencyUuid" => $agencyUuid]);           
    }

    private function insertUnitData($request, $unit){
        // generali
        $unit->name =                       $request->input("name");
        $unit->description =                $request->input("description");
        $unit->start_date =                 $request->input("start_date");       
        $unit->completion_date =            $request->input("completion_date");       
        $unit->price =                      $request->input("price");

        // struttura    
        $unit->size =                       $request->input("size");
        $unit->n_floors =                   $request->input("n_floors");
        $unit->n_room =                     $request->input("n_room");
        $unit->n_bathroom =                 $request->input("n_bathroom");
        

        // dettagli 
        $unit->parking =                    $request->has("parking");
        $unit->box =                        $request->has("box");
        $unit->elevator =                   $request->has("elevator");
        $unit->air_conditioning =           $request->has("air_conditioning");
        $unit->garden =                     $request->has("garden");
        $unit->independent =                $request->has("independent");
        $unit->green =                      $request->has("green");
        $unit->terrace =                    $request->has("terrace");
        $unit->luxury =                     $request->has("luxury");

        // consumi
        $unit->ape =                        $request->input("ape");
        $unit->heating_system_management =  $request->input("heating_system_management");
        $unit->heating_system_type =        $request->input("heating_system_type");
        $unit->heating_system_power =       $request->input("heating_system_power");

    }

    private function insertImages($request, $unit, $siteId){
        if ($request->filled('images_to_delete')) {
            $docsToDelete = $request->input('images_to_delete');
            
            $documents = ConstructionSiteImage::whereIn('id', $docsToDelete)
                ->where("id_construction_site", $siteId)
                ->get();

            foreach ($documents as $document) {
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                $document->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('construction_sites/images', 'public');

                $document = new ConstructionSiteImage();
                $document->id_construction_site = $siteId;
                $document->id_construction_site_unit = $unit->id;
                $document->path = $path;
                $document->name = $file->getClientOriginalName();
                $document->save();
            }
        }
    }

    public function delete($agencyUuid, $siteUuid){
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();

        if(!$construction || $construction->id_agency != $agency->id){
            return;
        }

        // rimuovo le immagini associate
        $images = ConstructionSiteImage::where("id_construction_site", $construction->id)->get();

        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        // rimuovo i documenti associati
        $documents = ConstructionSiteDocument::where("id_construction_site", $construction->id)->get();
        foreach ($documents as $document) {
            if (Storage::disk('public')->exists($document->path)) {
                Storage::disk('public')->delete($document->path);
            }
            $document->delete();
        }

        $construction->delete();

        return redirect()->back();
    }

    public function deleteUnit($agencyUuid, $siteUuid, $uuidUnit){
        $construction = ConstructionSite::where("uuid", $siteUuid)->first();
        $unit = ConstructionSiteUnit::where("uuid", $uuidUnit)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();

        if(!$construction || $construction->id_agency != $agency->id || $unit->id_construction_site != $construction->id){
            return;
        }

        // rimuovo le immagini associate
        $images = ConstructionSiteImage::where("id_construction_site_unit", $unit->id)->get();

        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        $unit->delete();

        return redirect()->back();
    }
}
