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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('film-list', 'FilmController@filmList');

Route::middleware('security')->prefix('web-api/')->group(function () {
    Route::get('films', 'API\SakilaController@filmList');
    Route::get('film-search', 'API\SakilaController@search');
    Route::get('film/{id}', 'API\SakilaController@film');
    Route::post('film', 'API\SakilaController@insert');
    Route::put('film', 'API\SakilaController@update');
    Route::delete('film/{id}', 'API\SakilaController@delete');
    Route::post('upload', 'API\SakilaController@upload');
});
