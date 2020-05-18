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
    // Matches "/account
    $router->get('test', function(){ echo 'hi.... api'; });
    $router->post('register', 'AuthController@register');
    $router->get('verify-token/{id}/{token}', 'AuthController@registerTokenVerification');
    $router->post('login', 'AuthController@login');
    $router->post('forget-password', 'PasswordController@forgetPassword');
    $router->get('password-reset/{id}/{token}', 'PasswordController@resetPassword');
    $router->post('password-reset-save', 'PasswordController@resetPasswordSave');
    $router->post('logout', 'AuthController@logout');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('{id}/show', 'UserController@singleUser');
    $router->get('list', 'UserController@allUsers');
    $router->post('verify-otp', 'AuthController@verifyOtp');
    $router->get('test-otp/{phone}', 'AuthController@testOtp');

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

// API route Company
$router->group(['prefix' => 'company','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'CompanyController@index');
    $router->post('create', 'CompanyController@store');
    $router->get('{id}/show', 'CompanyController@show');
    $router->get('{id}/edit', 'CompanyController@edit');
    $router->post('{id}/update','CompanyController@update');
    $router->post('search','CompanyController@search');
    $router->delete('{id}/delete','CompanyController@destroy');

});

// API route Category
$router->group(['prefix' => 'category','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'CategoryController@index');
    $router->post('create', 'CategoryController@store');
    $router->get('{id}/show', 'CategoryController@show');
    $router->get('{id}/edit', 'CategoryController@edit');
    $router->post('{id}/update','CategoryController@update');
    $router->post('search','CategoryController@search');
    $router->delete('{id}/delete','CategoryController@destroy');

});



// API route group mail
$router->group(['prefix' => 'mail'], function () use ($router) {
    $router->get('sendMeTest', 'EmailController@sendTestEmail');
    $router->get('user-email', 'UserController@sendEmail');
    $router->post('forget-password', 'PasswordController@forgetPassword');

});

// API route country
$router->group(['prefix' => 'country','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'CountryController@index');
    $router->post('create', 'CountryController@store');
    $router->get('{id}/show', 'CountryController@show');
    $router->get('{id}/edit', 'CountryController@edit');
    $router->post('{id}/update','CountryController@update');
    $router->post('search','CountryController@search');
    $router->delete('{id}/delete','CountryController@destroy');

});

// API route zone
$router->group(['prefix' => 'zone','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'ZoneController@index');
    $router->post('create', 'ZoneController@store');
    $router->get('{id}/show', 'ZoneController@show');
    $router->get('{id}/edit', 'ZoneController@edit');
    $router->post('{id}/update','ZoneController@update');
    $router->post('search','ZoneController@search');
    $router->delete('{id}/delete','ZoneController@destroy');

});

// API route menu operation
$router->group(['prefix' => 'menu_operations','middleware'=>'InputTrim'], function () use ($router) {
    $router->get('list', 'MenuOperationController@index');
    $router->post('create', 'MenuOperationController@store');
    $router->get('{id}/show', 'MenuOperationController@show');
    $router->get('{id}/edit', 'MenuOperationController@edit');
    $router->post('{id}/update','MenuOperationController@update');
    $router->post('search','MenuOperationController@search');
    $router->delete('{id}/delete','MenuOperationController@destroy');

});