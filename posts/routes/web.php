<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/posts', 'PostController@index');

Route::put('/posts/actualizar', 'PostController@update');

Route::post('/posts/guardar', 'PostController@store');

Route::delete('/posts/borrar/{id}', 'PostController@destroy');

Route::get('/posts/buscar', 'PostController@show');

Route::get('/', function () {
    return view('welcome');
});