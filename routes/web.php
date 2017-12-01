<?php

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


Route::get('login', 'AuthController@get_login')->name('login');
Route::post('login', 'AuthController@post_login')->name('post_login');
Route::get('register', 'AuthController@get_register')->name('register');
Route::post('register', 'AuthController@post_register')->name('post_register');
Route::post('logout', 'AuthController@get_logout')->name('get_logout');

Route::group(['middleware' => 'auth'], function() {
  Route::get('/', 'HomeController@index')->name('home');

  Route::group(['prefix' => 'siswa'], function() {
    Route::get('/', 'SiswaController@index')->name('siswa_index');
    Route::post('create', 'SiswaController@store')->name('siswa_store');
    Route::post('update', 'SiswaController@update')->name('siswa_update');
    Route::get('{id}/delete', 'SiswaController@delete')->name('siswa_delete');
  });
});
