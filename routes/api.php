<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/search", [ApiController::class, 'propertySearch']);

Route::get("/property/{uuid}/get", [ApiController::class, 'getSingleProperty']);
