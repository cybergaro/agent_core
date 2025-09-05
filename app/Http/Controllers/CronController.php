<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Services\BrevoMailer;
use App\Services\RealSmartImporter;


class CronController extends Controller
{
    public function propertiesImport()
    {
        $reali = new RealSmartImporter;

        $reali->import();

        dd("ok");
    }

}
