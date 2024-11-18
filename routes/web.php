<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });


$router->get('/', function () use ($router) {
    echo "<center> Welcome </center>";
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});

Route::group([
    'prefix' => 'api',
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout');
});

Route::group([
    'prefix' => 'api',
    'middleware' => 'jwtauth',
], function ($router) {
    // Artikel routes
    Route::post('artikel-store', 'ArtikelController@store');
    Route::put('artikel-update/{id}', 'ArtikelController@update');
    Route::delete('artikel-destroy/{id}', 'ArtikelController@destroy');
});