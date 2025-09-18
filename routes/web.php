<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\SocialController;

Route::get("/", function (){
    return redirect()->route("login");
})->name('home');

// Auth 
Route::middleware("guest")->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name("login");
    Route::post('/login', 'login');
    Route::get('/registration', 'showRegistration')->name("registration");
    Route::post('/registration', 'registration');
    
    Route::get('/emailCheck/{token}', 'emailCheck');
});

Route::get('/logout', [AuthController::class, 'logout'])->name("logout");


// Dashboard
Route::prefix('dashboard')->group(function () {

    Route::middleware("auth")->group(function () { 
        Route::get("/", [DashController::class, 'default'])->name("dashboard");
        Route::get("/agency/new", [AgencyController::class, 'showNew'])->name("agency:new");
        Route::post("/agency/new", [AgencyController::class, 'new']);

        Route::get("/user", [AuthController::class, 'new']);
    });
    
    Route::prefix("{agencyUuid}")->middleware('agency.canAccess')->group(function () {

        Route::get("/", [DashController::class, 'show'])->name("agency:dash");
        
        Route::get("/properties", [DashController::class, 'getProperties'])->name("agency:properties");
        Route::get("/property/new", [PropertiesController::class, 'newForm'])->name("agency:properties:new");
        Route::post("/property/new", [PropertiesController::class, 'new']);
        
        Route::get("/social", [SocialController::class, 'show'])->name("agency:social");

        Route::get("/settings", [DashController::class, 'settings'])->name("agency:settings");
        Route::get("/settings/import", [DashController::class, 'settingsImport'])->name("agency:settings:import");
        Route::post("/settings/import", [DashController::class, 'saveSettingsImport']);

        Route::get("/settings/agency", [DashController::class, 'agencySettingsShow']);
        Route::post("/settings/agency", [DashController::class, 'agencySettings']);

    });

});


// Croon
Route::get("/properties_import", [CronController::class, 'propertiesImport']);
