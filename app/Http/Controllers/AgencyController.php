<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Services\BrevoMailer;

use App\Models\User;
use App\Models\Agency;

class AgencyController extends Controller
{
    public function showNew()
    {   
        $title = "Nuova Agenzia";
        $header = false;

        return view("dash.agency.new.show", compact("title", "header"));
    }

    public function new(Request $request){

        if(Auth::user()->role != "admin"){
            return;
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^[+]?[\d\s\-]{6,20}$/'],
            'website' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $agency = new Agency();
        $agency->name = $request->input("name");
        $agency->email = $request->input("email");
        $agency->phone = $request->input("phone");
        $agency->website = $request->input("website");
        $agency->address = $request->input("address");
        $agency->save();
    
        return redirect()->route('agency:dash', ['agencyUuid' => $agency->uuid]);
    }
}
