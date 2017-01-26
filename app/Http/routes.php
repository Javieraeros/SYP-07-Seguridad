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

//TODO añadir metodo getToken que nos devuelva un token jwt
$app->get('/', function () use ($app) {
    return $app->version();
});
//Version 1.1
/*
 * $app->get('personas/{id}',['middleware'=>'auth:id',function($id){
    $persona=new \App\Http\Controllers\PersonaController();
    return $persona->getPersona($id);
}]);
 */

//Version 2.0    https://www.tutorialspoint.com/laravel/laravel_middleware.htm

$app->get('token','AuthController@getToken');

$app->get('personas/{id}',['middleware'=>'autho:id','uses'=>'PersonaController@getPersona']);

$app->get('personas','PersonaController@getPersonas');

$app->post('personas','PersonaController@postPersonas');

$app->delete('personas/{id}','PersonaController@deletePersona');

$app->put('personas/{id}','PersonaController@putPersona');
