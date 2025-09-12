<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                "properties.n_room",
                "properties.n_bathroom",
                "properties_images.path as image_path",
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

        if($request->uuidAgency){
            $agency = Agency::where("uuid", $request->uuidAgency)->first();

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

        $properties = $query->orderBy("properties.id", "DESC")
            ->paginate($request->inPage && $request->inPage < 30 ? $request->inPage : 30);

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

        $images = PropertyImage::where("id_property", $property->id)->get();
        $images360 = PropertyImage360::where("id_property", $property->id)->get();

        return response()->json([
            "status" => 200,
            "property" => $property,
            "images" => $images,
            "images360" => $images360,
        ]);

    }
}
