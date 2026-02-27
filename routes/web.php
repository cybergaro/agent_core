<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ConstructionSiteController;

Route::get("/", function (){
    return redirect()->route("login");
})->name('home');

// Auth 
Route::middleware("guest")->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name("login");
    Route::post('/login', 'login');

    Route::post('/createAdmin', 'createAdmin');

    // Route::get('/registration', 'showRegistration')->name("registration");
    // Route::post('/registration', 'registration');
    
});

Route::get('/logout', [AuthController::class, 'logout'])->name("logout");


// Dashboard
Route::prefix('dashboard')->group(function () {

    Route::middleware("auth")->group(function () { 
        Route::get("/", [DashController::class, 'default'])->name("dashboard");
        Route::get("/agency/new", [AgencyController::class, 'showNew'])->name("agency:new");
        Route::post("/agency/new", [AgencyController::class, 'new']);

        Route::get("/user", [AuthController::class, 'showUserSettings']);
        Route::post("/user", [AuthController::class, 'saveUserSettings']);
        
        Route::get("/user/password", [AuthController::class, 'showChangePassword']);
        Route::post("/user/password", [AuthController::class, 'changePassword']);
    });
    
    Route::prefix("{agencyUuid}")->middleware('agency.canAccess')->group(function () {

        Route::get("/", [DashController::class, 'show'])->name("agency:dash");
        
        Route::get("/properties", [DashController::class, 'getProperties'])->name("agency:properties");
        Route::get("/property/new", [PropertiesController::class, 'newForm'])->name("agency:properties:new");
        Route::post("/property/new", [PropertiesController::class, 'new']);
        Route::get("/property/{propertyUuid}", [PropertiesController::class, 'showEdit']);
        
        Route::get("/construction_sites", [DashController::class, 'getConstructionSite'])->name("agency:construction");
        Route::get("/construction_site/new", [ConstructionSiteController::class, 'showNew']);
        Route::post("/construction_site/new", [ConstructionSiteController::class, 'new']);
        Route::get("/construction_site/{siteUuid}", [ConstructionSiteController::class, 'showEdit']);
        Route::post("/construction_site/{siteUuid}", [ConstructionSiteController::class, 'edit']);
        Route::get("/construction_site/{siteUuid}/delete", [ConstructionSiteController::class, 'delete']);
        Route::get("/construction_site/{siteUuid}/units", [ConstructionSiteController::class, 'showUnits'])->name("site:units");
        Route::get("/construction_site/{siteUuid}/unit/new", [ConstructionSiteController::class, 'showNewUnit'])->name("site:unit:new");
        Route::post("/construction_site/{siteUuid}/unit/new", [ConstructionSiteController::class, 'newUnit']);
        Route::get("/construction_site/{siteUuid}/unit/{uuidUnit}", [ConstructionSiteController::class, 'showEditUnit'])->name("site:unit:edit");
        Route::post("/construction_site/{siteUuid}/unit/{uuidUnit}", [ConstructionSiteController::class, 'editUnit']);
        Route::get("/construction_site/{siteUuid}/unit/{uuidUnit}/delete", [ConstructionSiteController::class, 'deleteUnit']);

        Route::get("/social", [SocialController::class, 'show'])->name("agency:social");

        Route::get("/website", [DashController::class, 'showWebsite'])->name("agency:website");
        Route::get("/website/messages", [DashController::class, 'showMessages']);

        Route::get("/users", [DashController::class, 'showAgencyUsers'])->name("agency:users");

        Route::get("/settings", [DashController::class, 'settings'])->name("agency:settings");
        Route::get("/settings/import", [DashController::class, 'settingsImport'])->name("agency:settings:import");
        Route::post("/settings/import", [DashController::class, 'saveSettingsImport']);

        Route::get("/settings/export", [DashController::class, 'settingsExport'])->name("agency:settings:export");
        Route::post("/settings/export", [DashController::class, 'saveSettingsExport']);
        
        Route::get("/settings/api", [DashController::class, 'settingsApi'])->name("agency:settings:api");
        Route::post("/settings/api", [DashController::class, 'saveSettingsApi']);

        Route::get("/settings/agency", [DashController::class, 'agencySettingsShow']);
        Route::post("/settings/agency", [DashController::class, 'agencySettings']);

    });

});


// test
Route::get("/test/facebook", [SocialController::class, 'test']);

// Croon
Route::get("/properties_import", [CronController::class, 'propertiesImport']);
