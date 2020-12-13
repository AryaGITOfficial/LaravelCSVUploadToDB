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

//Route::get('/', 'CSVFilesController@index'); // localhost:8000/
//Route::post('/uploadFile', 'CSVFilesController@uploadFile');

Route::get('/', 'CSVFilesController@create');
Route::post('/uploadFile', 'CSVFilesController@store');
