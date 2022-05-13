<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\JWTController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [JWTController::class, 'login']);
    Route::post('register', [JWTController::class, 'register']);
    Route::post('logout', [JWTController::class, 'logout']);
    Route::get('refresh', [JWTController::class, 'refresh']);
    Route::get('me', [JWTController::class, 'me']);
});
