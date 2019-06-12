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

$router->get('/pois', "PoiController@all");
$router->get('/pois/{id}', "PoiController@one");
$router->post('/pois', "PoiController@create");
$router->put('/pois/{id}', "PoiController@update");
$router->delete('/pois/{id}', "PoiController@delete");
