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
    return $router->app->version();
});

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->get('/', 'CategoryController@index');
        $router->post('/', 'CategoryController@store');
        $router->get('{categoryId}', 'CategoryController@show');
        $router->put('{categoryId}', 'CategoryController@update');
        $router->delete('{categoryId}', 'CategoryController@destroy');
    });

    $router->group(['prefix' => 'label'], function () use ($router) {
        $router->get('/', 'LabelController@index');
        $router->post('/', 'LabelController@store');
        $router->get('{labelId}', 'LabelController@show');
        $router->put('{labelId}', 'LabelController@update');
        $router->delete('{labelId}', 'LabelController@destroy');
    });

    $router->group(['prefix' => 'issue'], function () use ($router) {
        $router->get('/', 'IssueController@index');
        $router->post('/', 'IssueController@store');
        $router->get('{issueId}', 'IssueController@show');
        $router->put('{issueId}', 'IssueController@update');
        $router->delete('{issueId}', 'IssueController@destroy');
    });
});
