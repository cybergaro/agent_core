<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\Agency;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyImage360;

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

        if($request->contracts){
            $query->whereIn("contract", $request->contracts);
        }

        if($request->types){
            $query->whereIn("type", $request->types);
        }

        if($request->categories){
            $query->whereIn("category", $request->categories);
        }

        if($request->similarTo){
            $query->where("uuid", "!=", $request->similarTo);
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

        return response()->json($property);

    }
}
