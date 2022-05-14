<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\JWTController;

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
], function () use ($router) {
    $router->post('login', [
        'as' => 'jwt.login', 'uses' => 'JWTController@login'
    ]);
    $router->post('register', [
        'as' => 'jwt.register', 'uses' => 'JWTController@register'
    ]);
    $router->post('logout', [
        'as' => 'jwt.logout', 'uses' => 'JWTController@logout'
    ]);
    $router->get('refresh', [
        'as' => 'jwt.refresh', 'uses' => 'JWTController@refresh'
    ]);
    $router->get('me', [
        'as' => 'jwt.me', 'uses' => 'JWTController@me'
    ]);
});
