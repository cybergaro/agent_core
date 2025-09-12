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

        $header = false;
        return view("dash.properties.new.show", compact("header", "propertyTypes"));
    }

}
