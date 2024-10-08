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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
        $router->post('/login', 'AuthController@login');
        
        $router->group(['middleware' => 'auth:api'], function () use ($router){
            $router->post('/logout', 'AuthController@logout');
            $router->get('/divisions', 'DivisionController@index');
            $router->get('/employees', 'KaryawanController@index');
            $router->post('/employees', 'KaryawanController@store');
            $router->post('/employees/{id}', 'KaryawanController@update');
            $router->delete('/employees/{id}', 'KaryawanController@destroy');
        });
});