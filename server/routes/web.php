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


$router->group(['prefix' => 'api'], function () use ($router) {

    //auth routes
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/', 'AuthController@register');
    });

    //post routes
    $router->group(['prefix' => 'posts'], function () use ($router) {
    $router->post('/', 'PostController@createPost');    
    });

 

});


$router->get('/', function () use ($router) {
    return $router->app->version();
});




