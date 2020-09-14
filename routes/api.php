<?php

use Illuminate\Support\Facades\Hash;
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

Route::middleware('auth:api')->group(function() {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::resource('products', 'API\ProductController');
});

Route::get('hello', function () {
    return 'Hello World';
});

Route::get('hello-json', function () {
    $array = ['name' => 'Zulhilmi', 'address' => 'Putrajaya'];
    return $array;
});

Route::get('gen-token', function () {
    return Hash::make('Terkejut-' . date('Y-m-d.H:i:s'));
});

Route::middleware('guard.api')->group(function () {
    Route::get('films', 'API\SakilaController@filmList');
    Route::get('film-search', 'API\SakilaController@search');
    Route::get('film/{id}', 'API\SakilaController@film');
    Route::post('film', 'API\SakilaController@insert');
    Route::put('film', 'API\SakilaController@update');
    Route::delete('film/{id}', 'API\SakilaController@delete');
    Route::post('upload', 'API\SakilaController@upload');
});
