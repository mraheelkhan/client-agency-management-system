<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
Use App\Http\Controllers\V1\RegisterController;
/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Register user invokable controller
 */
// Registration...
if (Features::enabled(Features::registration())) {
    Route::post('/register', RegisterController::class)
        ->middleware(['guest:'.config('fortify.guard')]);
}

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
