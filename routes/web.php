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

Route::get('/client', 'ClientController@registrate');
Route::get('/client/{client_number}', 'ClientController@checkResult');
Route::get('/server', 'GameController@startGame');

Route::get('/', function () {
    return view('welcome');
});
