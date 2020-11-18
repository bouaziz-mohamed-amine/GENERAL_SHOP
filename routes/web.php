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
Route::get('amine','DataImportController@importUnits');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('test-admin',function(){return 'hello';});

Route::middleware(['auth', 'admin'])->group(function () {
        //units
    Route::resource('units','UnitController');
    Route::post('units/search','UnitController@search')->name('units.search');
    //products
    Route::resource('products','ProductController');
});
