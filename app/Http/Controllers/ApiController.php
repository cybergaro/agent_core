<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Services\BrevoMailer;

use App\Models\Agency;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyImage360;
use App\Models\PropertyFloorPlan;
use App\Models\WebsiteEmail;

class ApiController extends Controller
{
    public function propertySearch(Request $request){

        if((isset($request->basic) && $request->basic) || !isset($request->basic)){
            $query = Property::select(
                "properties.uuid",
                "properties.name",
                "properties.contract",
                "properties.type",
                "properties.category",
                "properties.price",
                "properties.size",
                "properties.address",
                "properties.n_room",
                "properties.n_bathroom",
                "properties.green",
                "properties.luxury",
                "properties.latitude",  
                "properties.longitude",
                DB::raw("CONCAT('" . env("APP_URL") .Storage::url('properties_images').'/'. "', properties_images.path) as image_url")
            );
        }else{
            $query = Property::select("properties.*");
        }

        $query->leftJoin(
            'properties_images', 
            function ($join) {
                $join->on('properties_images.id_property', '=', 'properties.id')
                    ->whereRaw('properties_images.id = (SELECT MIN(id) FROM properties_images WHERE properties_images.id_property = properties.id)');
            }
        );

        if($request->agency){
            $agency = Agency::where("uuid", $request->agency)->first();

            if(!$agency){
                return response()->json([
                    "status" => 400,
                    "error" => "This agency does not exist"
                ]);
            }

            $query->where("id_agency", $agency->id);
        }

        if($request->contracts && count($request->contracts)){
            $query->whereIn("contract", $request->contracts);
        }

        if($request->types && count($request->types)){
            $query->whereIn("type", $request->types);
        }

        if($request->categories && count($request->categories)){
            $query->whereIn("category", $request->categories);
        }

        if($request->similarTo){
            $query->where("uuid", "!=", $request->similarTo);
        }

        // GEOLOCALIZZAZIONE E ORDINAMENTO
    
        $radius = 1; // Km

        if($request->lat && $request->lng){
            $lat = (float) $request->lat;
            $lng = (float) $request->lng;

            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lng)) + sin(radians($lat)) * sin(radians(latitude))))";

            $query->addSelect(DB::raw("$haversine AS distance"));

            $query->whereRaw("$haversine <= ?", [$radius]);

            $query->orderBy('distance', 'ASC');
        } else {
            $query->orderBy("properties.id", "DESC");
        }


        $properties = $query->orderBy("properties.id", "DESC")
            ->paginate($request->limit && $request->limit < 30 ? $request->limit : 30);

        return response()->json($properties);
    }

    public function getSingleProperty($uuid){
        $property = Property::where("uuid", $uuid)->first();

        if(!$property){
            return response()->json([
                "status" => 400,
                "error" => "This property does not exist"
            ]);
        }

        $images = PropertyImage::select(
            DB::raw("CONCAT('" . env("APP_URL") .Storage::url('properties_images').'/'. "', properties_images.path) as image_url")
        )->where("id_property", $property->id)->get();
        
        $images360 = PropertyImage360::select(
            DB::raw("CONCAT('" . env("APP_URL") .Storage::url('properties_360_images').'/'. "', properties_360_images.path) as image_url")
        )->where("id_property", $property->id)->get();

        $property["images"] = $images->pluck('image_url');
        $property["images360"] = $images360->pluck('image_url');

        $floorPlans = PropertyFloorPlan::select(
            DB::raw("CONCAT('" . env("APP_URL") .Storage::url('properties_floor_plans').'/'. "', properties_floor_plans.path) as image_url")
        )->where("id_property", $property->id)->get();;
            
        $property["floors"] = array();
        $property["floors"][]["plans"] = $floorPlans->pluck("image_url");

        return response()->json($property);

    }

    public function sendEvalutationEmail(Request $request){

        $validator = Validator::make($request->all(), [
            'uuid_agency'   => 'required|uuid',
            'name'        => 'nullable|string|max:255',
            'tel'     => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255',
            'n_room'      => 'nullable|integer|min:1',
            'size'        => 'nullable|numeric|min:0',
            'address'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $agency = Agency::where("uuid", $request->uuid_agency)->first();
        
        if(!$agency){
            return response()->json([
                "status" => 400,
                "error" => "This agency does not exist"
            ]);
        }

        if(!$agency->website_connection){
            return response()->json([
                "status" => 400,
                "error" => "This agency is not enabled to use this method"
            ]);
        }

        $emailDb = new WebsiteEmail;
        $emailDb->id_agency = $agency->id;
        $emailDb->name = $request->name;
        $emailDb->tel = $request->tel;
        $emailDb->email = $request->email;
        $emailDb->n_room = $request->n_room;
        $emailDb->size = $request->size;
        $emailDb->address = $request->address;
        $emailDb->description = $request->description;
        $emailDb->save();     

        
        $html = view('emails.childWebsite.evalutationRequest', [
            'name' => $request->name,
            'tel' => $request->tel,
            'email' => $request->email,
            'address' => $request->address,
            'description' => $request->description,
            'n_room' => $request->n_room,
            'size' => $request->size,
        ])->render();

        $mailer = new BrevoMailer();

        $mailer->sendCustomEmail(
            $agency->email,
            $agency->name,
            'Nuova richiesta di valutazione',
            $html
        );
    }
}
