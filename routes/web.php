<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\CronController;

Route::get("/", function (){
    return redirect()->route("login");
})->name('home');

// Auth 
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name("login");
    Route::post('/login', 'login');
    Route::get('/registration', 'showRegistration')->name("registration");
    Route::post('/registration', 'registration');
    
    Route::get('/emailCheck/{token}', 'emailCheck');
});

Route::get('/logout', [AuthController::class, 'logout'])->name("logout");

// Dashboard
Route::get("/dashboard", [DashController::class, 'default'])->name("dashboard");
Route::get("/dashboard/agency/new", [AgencyController::class, 'showNew'])->name("agency:new");
Route::post("/dashboard/agency/new", [AgencyController::class, 'new']);

Route::get("/dashboard/user", [AuthController::class, 'new']);

// serve un middleware che verifica che l'utente è abilitato a vedere i dati di questa agenzia
Route::get("/dashboard/{agencyUuid}", [DashController::class, 'show'])->name("agency:dash");
Route::get("/dashboard/{agencyUuid}/properties", [DashController::class, 'getProperties'])->name("agency:properties");
Route::get("/dashboard/{agencyUuid}/settings", [DashController::class, 'settings'])->name("agency:settings");
Route::get("/dashboard/{agencyUuid}/settings/import", [DashController::class, 'settingsImport'])->name("agency:settings:import");
Route::post("/dashboard/{agencyUuid}/settings/import", [DashController::class, 'saveSettingsImport']);


// Croon

Route::get("/properties_import", [CronController::class, 'propertiesImport']);
