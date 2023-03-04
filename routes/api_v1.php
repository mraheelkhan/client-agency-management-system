<?php

use App\Http\Controllers\V1\Auth\LoginUserController;
use App\Http\Controllers\V1\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use \App\Http\Controllers\V1\ClientController;
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

//$limiter = config('fortify.limiters.login');
$limiter = 20;

Route::post('/login', LoginUserController::class)
    ->middleware(array_filter([
        'guest:'.config('fortify.guard'),
        $limiter ? 'throttle:'.$limiter : null,
    ]));

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::resource('/clients', ClientController::class);
});
