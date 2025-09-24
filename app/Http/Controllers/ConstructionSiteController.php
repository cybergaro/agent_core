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
use App\Models\WebsiteEmail;
use App\Models\ConstructionSite;

class ConstructionSiteController extends Controller
{
    public function showNew($agencyUuid){
        $construction = new ConstructionSite();
        $title = "Nuovo cantiere";

        return view("dash.constructionSites.new.show", compact("construction", "title"));
    }
}
