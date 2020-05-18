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

$router->get('/', function () use ($router) {
   // return $router->app->version();
    return "Welcome To Tizaara API";
});

// API route group account
$router->group(['prefix' => 'account','middleware'=>'InputTrim'], function () use ($router) {
    // Matches "/api/account
    $router->get('test', function(){ echo 'hi.... api'; });
    $router->post('register', 'AuthController@register');
    $router->get('verify-token/{id}/{verify_token}', 'AuthController@registerTokenVerification');
    $router->post('login', 'AuthController@login');
    $router->post('forget-password', 'PasswordController@forgetPassword');
    $router->get('password-reset/{id}/{token}', 'PasswordController@resetPassword');
    $router->post('password-reset-save', 'PasswordController@resetPasswordSave');
    $router->post('logout', 'AuthController@logout');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('{id}/show', 'UserController@singleUser');
    $router->get('list', 'UserController@allUsers');

});

// API route group Business Types
$router->group(['prefix' => 'btype','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'BusinessTypeController@index');
    $router->post('create', 'BusinessTypeController@store');
    $router->get('{id}/show', 'BusinessTypeController@show');
    $router->get('{id}/edit', 'BusinessTypeController@edit');
    $router->post('{id}/update','BusinessTypeController@update');
    $router->post('search','BusinessTypeController@search');
    $router->delete('{id}/delete','BusinessTypeController@destroy');

});

// API route group Brands
$router->group(['prefix' => 'brand','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'BrandController@index');
    $router->post('create', 'BrandController@store');
    $router->get('{id}/show', 'BrandController@show');
    $router->get('{id}/edit', 'BrandController@edit');
    $router->post('{id}/update','BrandController@update');
    $router->post('search','BrandController@search');
    $router->delete('{id}/delete','BrandController@destroy');

});

// API route group product/attribute/group
$router->group(['prefix' => 'product/attribute/group','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'AttributeGroupController@index');
    $router->post('create', 'AttributeGroupController@store');
    $router->get('{id}/show', 'AttributeGroupController@show');
    $router->get('{id}/edit', 'AttributeGroupController@edit');
    $router->post('{id}/update','AttributeGroupController@update');
    $router->post('search','AttributeGroupController@search');
    $router->delete('{id}/delete','AttributeGroupController@destroy');

});

// API route group product/attribute
$router->group(['prefix' => 'product/attribute','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('/', 'AttributeController@index');//$router->get('list', 'AttributeController@index');
    $router->post('/', 'AttributeController@store');// $router->post('create', 'AttributeController@store');
    $router->get('{id}', 'AttributeController@show');//$router->get('{id}/show', 'AttributeController@show');
    $router->post('{id}/update','AttributeController@update');//$router->post('{id}/update','AttributeController@update');
    $router->delete('{id}','AttributeController@destroy'); //$router->delete('{id}/delete','AttributeController@destroy');
    $router->post('search','AttributeController@search');

});

// API route group mail
$router->group(['prefix' => 'mail'], function () use ($router) {
    $router->get('sendMeTest', 'EmailController@sendTestEmail');
    $router->get('user-email', 'UserController@sendEmail');
    $router->post('forget-password', 'PasswordController@forgetPassword');

});
