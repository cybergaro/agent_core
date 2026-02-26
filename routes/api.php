<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// properties
Route::get("/properties", [ApiController::class, 'propertySearch']);
Route::get("/property/{uuid}", [ApiController::class, 'getSingleProperty']);

// construction sites
Route::get("/construction_sites", [ApiController::class, 'constructionSites']);
Route::get("/construction_site/{uuid}", [ApiController::class, 'constructionSite']);

Route::post("/child_website/evalutation_email", [ApiController::class, 'sendEvalutationEmail']);
