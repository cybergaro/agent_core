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
use App\Models\ConstructionSite;
use App\Models\ConstructionSiteImage;
use App\Models\Agency;
use App\Models\Property;
use App\Models\Message;

class DashController extends Controller
{
    public function default()
    {
        // caso utente amministratore
        if(Auth::user()->role == "admin"){
            $agencies = Agency::orderBy("name", "ASC")->get();
            
            if(!count($agencies)){
                return redirect()->route("agency:new");
            }

            $header = false;

            return view("agencies", compact("agencies", "header"));

        }else{ // caso utente "agente"
            $agencies = Agency::where("id_user_owner", Auth::id())->get();
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

        $notifications = [];
        
        if($agency->website_connection){
            $notifications = Message::where("id_agency", $agency->id)
                ->orderBy("id", "DESC")
                ->limit(6)
                ->get();
        }
    
        return view("dash.agency.home", compact("title", "propertyType", "notifications"));
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
            ->paginate(10);

        $title = "Immobili";
        
        return view("dash.properties.list", compact("properties", "title"));
    }

    public function getConstructionSite($agencyUuid){
        $agency = Agency::where("uuid", $agencyUuid)->first();

        $sites = ConstructionSite::select("construction_sites.*")
            ->addSelect([
                'image_path' => ConstructionSiteImage::select("path")
                    ->whereColumn('id_construction_site', 'construction_sites.id')
                    ->orderBy('id', 'asc')
                    ->limit(1)
            ])
            ->where("id_agency", $agency->id)
            ->orderBy("id", "DESC")
            ->paginate(10);

        $title = "Cantieri";
        
        return view("dash.constructionSites.list", compact("sites", "title"));
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

    public function settingsExport($agencyUuid){
        $agency = Agency::where("uuid", $agencyUuid)->first();
        
        $title = "Impostazioni esportazione";

        return view("dash.agency.settings.export", compact("agency", "title"));
    }

    public function saveSettingsExport($agencyUuid, Request $request){

        $agency = Agency::where("uuid", $agencyUuid)->first();
        
        $agency->google_cloud_credentials = $request->input("google_cloud_credentials");
        $agency->google_sheet_id = $request->input("google_sheet_id");

        $agency->save();

        return redirect()->back()->withSuccess("Impostazioni modificate");
    }   

    public function settingsApi($agencyUuid, Request $request){
        $agency = Agency::where("uuid", $agencyUuid)->first();
        
        $title = "API";

        return view("dash.agency.settings.api", compact("agency", "title"));
    }   

     public function saveSettingsApi($agencyUuid, Request $request){
        $agency = Agency::where("uuid", $agencyUuid)->first();
        
        $agency->website_connection = $request->has("website_connection");

        // Re-Captcha
        $agency->enable_captcha = $request->has("enable_captcha");
        $agency->captcha_key = $request->input("captcha_key");

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

    public function showWebsite($agencyUuid, Request $request){
        
        $title = "Sito web";
        $agency = Agency::where("uuid", $agencyUuid)->first();


        return view("dash.website.show", compact("agency", "title"));
    }

    public function showMessages($agencyUuid){
        $title = "Messaggi";
        $agency = Agency::where("uuid", $agencyUuid)->first();

        $messages = Message::where("id_agency", $agency->id)->orderBy("id", "DESC")->get();

        return view("dash.website.messages", compact("agency", "title", "messages"));
    }

    public function getSingleMessage($agencyUuid, $id){

        $agency = Agency::where("uuid", $agencyUuid)->first();
        
        $message = Message::where("id_agency", $agency->id)->where("id", $id)->first();

        return view("dash.website.messagePartial", compact("agency", "message"));
    }

    public function showAgencyUsers($agencyUuid){
        if(Auth::user()->role != "admin"){return;}

        $agency = Agency::where("uuid", $agencyUuid)->first();
        $users = User::where("id_agency", $agency->id)->orderBy("name", "ASC")->get();

        $title = "Agenti";

        return view("dash.agency.users.show", compact("title", "users"));
    }
}
