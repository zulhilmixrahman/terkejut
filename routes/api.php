<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::post('register', 'API\RegisterController@register');
// Route::post('login', 'API\RegisterController@login');

// Route::middleware('auth:api')->group(function() {
//     Route::resource('products', 'API\ProductController');
// });

Route::get('hello', function () {
    return 'Hello World';
});


Route::get('hello-json', function () {
    $array = ['name' => 'Zulhilmi', 'address' => 'Putrajaya'];
    return $array;
});

Route::get('films', 'API\SakilaController@filmList');
Route::get('film-search', 'API\SakilaController@search');
Route::get('film/{id}', 'API\SakilaController@film');
Route::post('film', 'API\SakilaController@insert');
Route::patch('film', 'API\SakilaController@update');
