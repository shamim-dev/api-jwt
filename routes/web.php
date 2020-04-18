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

/*$router->get('/', function () use ($router) {
    return $router->app->version();
});*/

// API route group account
$router->group(['middleware'=>'InputTrim','prefix' => 'api/account'], function () use ($router) {
    // Matches "/api/register
    $router->get('test', function(){ echo 'hi.... api'; });
    $router->post('register', 'AuthController@register');
    $router->get('verify-token/{id}/{token}', 'AuthController@registerTokenVerification');
    $router->post('login', 'AuthController@login');
    $router->post('forget-password', 'PasswordController@forgetPassword');
    $router->get('password-reset/{id}/{token}', 'PasswordController@resetPassword');
    $router->post('password-reset-save', 'PasswordController@resetPasswordSave');
    $router->get('logout', 'AuthController@logout');
    $router->get('logout', 'AuthController@logout');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('{id}/show', 'UserController@singleUser');
    $router->get('list', 'UserController@allUsers');

});

// API route group mail
$router->group(['prefix' => 'api/mail'], function () use ($router) {
    $router->get('sendMeTest', 'EmailController@sendTestEmail');
    $router->get('user-email', 'UserController@sendEmail');

});
