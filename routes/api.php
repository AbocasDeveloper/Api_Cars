<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Para utilizar estas rutas, hay que iniciar el servidor con el comando 'php artisan serve'
 * Además a las rutas hay que añadirle /api siempre delante para que funcione correctamente
 * 
 * Ejemplo -> http://localhost:8000/api/register
 */

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::resource('/cars', 'CarController');
