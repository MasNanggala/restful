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


$router->get('/api/buku/','BukuController@getBuku');
$router->get('/api/buku/{id}','BukuController@getByID');
$router->post('/api/buku/','BukuController@insertBuku');
$router->put('/api/buku/{id}','BukuController@updateBuku');
$router->delete('/api/buku/{id}','BukuController@deleteBuku');

$router->post('/api/login','AuthBuku@login');