<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Services\BrevoMailer;

use App\Models\User;
use App\Models\EmailVerifyToken;
use App\Models\Agency;
use App\Models\Property;

class DashController extends Controller
{
    public function default()
    {
        $title = "Dashboard";

        // recurpero
        $agencies = Agency::where("id_user_owner", Auth::id())->get();

        if(!count($agencies)){
            return redirect()->route("agency:new");
        }

        return redirect()->route("agency:dash", ["agencyUuid" => $agencies[0]->uuid]);
    }

    public function show($agencyUuid){

        $agency = Agency::where("uuid", $agencyUuid)->first();
        $title = $agency->name;

        $propertyType = DB::table('properties')
            ->select('type', DB::raw('COUNT(*) as total'))
            ->where("id_agency", $agency->id)
            ->groupBy('type')
            ->get();
    
        return view("dash.agency.home", compact("title", "propertyType"));
    }   

    public function getProperties($agencyUuid){

        $agency = Agency::where("uuid", $agencyUuid)->first();

        $properties = Property::where("id_agency", $agency->id)
            ->select(
                "properties.*",
                "properties_images.path as image_path",
            )
            ->leftJoin(
                'properties_images', 
                function ($join) {
                    $join->on('properties_images.id_property', '=', 'properties.id')
                        ->whereRaw('properties_images.id = (SELECT MIN(id) FROM properties_images WHERE properties_images.id_property = properties.id)');
                }
            )
            ->orderBy("id", "DESC")
            ->get();

        $title = "Immobili";
        
        return view("dash.properties.list", compact("properties", "title"));
    }

    public function settings($agencyUuid){
        return view("dash.agency.settings.show");
    }   

    public function settingsImport($agencyUuid){
        $agency = Agency::where("uuid", $agencyUuid)->first();

        $title = "Impostazioni importazione";

        return view("dash.agency.settings.import", compact("agency", "title"));
    }   

    public function saveSettingsImport($agencyUuid, Request $request){
        $agency = Agency::where("uuid", $agencyUuid)->first();
        
        // real smart
        $agency->real_smart_xml_url = $request->input("real_smart_xml_url");
        $agency->enable_real_smart_importer = $request->has("enable_real_smart_importer");
        $agency->real_smart_remove_after_delete = $request->has("real_smart_remove_after_delete");

        $agency->save();

        return redirect()->back()->withSuccess("Impostazioni modificate");
    }   

    public function agencySettingsShow($agencyUuid){
        $agency = Agency::where("uuid", $agencyUuid)->first();

        return view("dash.agency.settings.agency", compact("agency"));
    }

    public function agencySettings($agencyUuid, Request $request){
        $agency = Agency::where("uuid", $agencyUuid)->first();

        $agency->name =         $request->input("name");
        $agency->email =        $request->input("email");
        $agency->phone =        $request->input("phone");
        $agency->website =      $request->input("website");
        $agency->save();

        return redirect()->back()->withSuccess("Impostazioni modificate");
    }
}
