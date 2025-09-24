<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Services\BrevoMailer;

use App\Models\User;
use App\Models\EmailVerifyToken;
use App\Models\Agency;
use App\Models\Property;

class PropertiesController extends Controller
{
    public function newForm(){

        $property = new Property;

        return view("dash.properties.new.show", compact("property"));
    }

    public function new(Request $request){
        $property = new Property();
        
        // generali
        $property->name =                       $request->input("name");
        $property->description =                $request->input("description");
        $property->contract =                   $request->input("contract");
        $property->type =                       $request->input("type");
        $property->category =                   $request->input("category");

        // prezzo       
        $property->price =                      $request->input("price");

        // costi        
        $property->condominium_fees =           $request->input("condominium_fees");

        // struttura    
        $property->size =                       $request->input("size");
        $property->n_floors =                   $request->input("n_floors");
        $property->n_room =                     $request->input("n_room");
        $property->n_bathroom =                 $request->input("n_bathroom");
        $property->year_production =            $request->input("year_production");
        $property->floor =                      $request->input("floor");

        // dettagli 
        $property->parking =                    $request->has("parking");
        $property->box =                        $request->has("box");
        $property->elevator =                   $request->has("elevator");
        $property->air_conditioning =           $request->has("air_conditioning");
        $property->garden =                     $request->has("garden");
        $property->independent =                $request->has("independent");
        $property->green =                      $request->has("green");
        $property->terrace =                    $request->has("terrace");
        $property->luxury =                     $request->has("luxury");

        // consumi
        $property->ape =                        $request->input("ape");
        $property->heating_system_management =  $request->input("heating_system_management");
        $property->heating_system_type =        $request->input("heating_system_type");
        $property->heating_system_power =       $request->input("heating_system_power");

        // condizione attuale
        $property->occupancy_status =           $request->input("occupancy_status");
        $property->internal_condition =         $request->input("internal_condition");
        $property->furniture =                  $request->input("furniture");

        dd($property);
        // $property->save();

    }

    public function showEdit($agencyUuid, $propertyUuid){

        $property = Property::where("uuid", $propertyUuid)->first();
        $agency = Agency::where("uuid", $agencyUuid)->first();

        if(!$property){
            return "Immobile non esistente";
        }

        if($property->id_agency != $agency->id){
            return "Non sei autorizzato a modificare questo immobile";
        }

        return view("dash.properties.new.show", compact("property"));
    }
}
