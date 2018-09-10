<?php

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

$router->group(['middleware' => 'laravel.jwt'], function () use ($router) {
    $router->get('user', function () {
        return auth()->user();
    });
    $router->post('logout', ['uses' => 'Auth\LoginController@logout']);
    $router->patch('settings/profile', ['uses' => 'Settings\ProfileController@update']);
    $router->patch('settings/password', ['uses' => 'Settings\PasswordController@update']);

    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->post('create', ['uses' => 'Admin\ProductsController@create']);
        $router->post('update/{id:[0-9]}', ['uses' => 'Admin\ProductsController@update']);
        // $router->post('delete', ['uses' => 'Admin\ProductsController@delete']);
    });

    // $router->group(['prefix' => 'orders'], function () use ($router) {
    //     $router->post('update/{id:[0-9]}', ['uses' => 'Admin\OrdersController@update']);
    // });
});

$router->group([], function () use ($router) {
    $router->post('register', ['uses' => 'Auth\RegisterController@store']);
    $router->post('login', ['uses' => 'Auth\LoginController@login']);
    $router->post('login/{token}', ['uses' => 'Auth\LoginController@loginToken']);

    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('', ['uses' => 'Admin\ProductsController@all']);
        $router->get('{id:[0-9]}', ['uses' => 'Admin\ProductsController@find']);
        $router->post('export', ['uses' => 'Admin\ProductsController@export']);
        $router->post('import', ['uses' => 'Admin\ProductsController@import']);
    });

    $router->group(['prefix' => 'orders'], function () use ($router) {
        $router->get('', ['uses' => 'Admin\OrdersController@all']);
        $router->get('{id:[0-9]}', ['uses' => 'Admin\OrdersController@find']);

        $router->post('create', ['uses' => 'Admin\OrdersController@create']);

        $router->post('export', ['uses' => 'Admin\\OrdersController@export']);
        $router->post('import', ['uses' => 'Admin\\OrdersController@import']);
        $router->post('update/{id:[0-9]}', ['uses' => 'Admin\OrdersController@update']);
    });
});

$router->group(['prefix' => 'password'], function () use ($router) {
    $router->post('email', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    $router->post('reset', ['uses' => 'Auth\ResetPasswordController@reset']);
});
