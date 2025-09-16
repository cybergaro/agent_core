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

        $propertyTypes = [
            'apartment',
            'single-family-house',
            'multi-family-house',
            'townhouse',
            'villa',
            'loft',
            'studio-apartment',
            'penthouse',
            'farmhouse',
            'cottage',
            'office',
            'shop',
            'commercial-space',
            'hotel',
            'restaurant',
            'showroom',
            'retail',
            'bar',
            'theater',
            'industrial-warehouse',
            'logistics-hub',
            'workshop',
            'agricultural-land',
            'building-land',
            'garage',
            'parking-lot',
            'storage-unit'
        ];
        
        $heatingSystemManagment = ['autonomous', 'centralized', 'semi-centralized'];
        $heatingSystemType = ['radiators', 'underfloor', 'wall', 'ceiling', 'fan_coil', 'stove', 'fireplace', 'heat_pump'];
        $heatingSystemPower = ['gas', 'gpl', 'diesel', 'electric', 'pellet', 'wood', 'solar', 'district'];

        $header = true;
        return view("dash.properties.new.show", compact("header", "propertyTypes", "heatingSystemManagment", "heatingSystemType", "heatingSystemPower"));
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
}
