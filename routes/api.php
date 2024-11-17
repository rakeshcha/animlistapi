<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FetchDataFromAnimApi;
use App\Http\Controllers\AnimeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/fetch-anime-data', [FetchDataFromAnimApi::class, 'fetchAndStore']);


Route::get('/anime/{slug}', [AnimeController::class, 'show']);

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Route not found.',
    ], 404);
});