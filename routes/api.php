<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/properties", [ApiController::class, 'propertySearch']);

Route::get("/property/{uuid}", [ApiController::class, 'getSingleProperty']);

Route::post("/child_website/evalutation_email", [ApiController::class, 'sendEvalutationEmail']);
