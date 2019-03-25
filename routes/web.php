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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('profile', 'UserController@edit')->middleware('auth')->name('profile.edit');
Route::post('profile', 'UserController@update')->middleware('auth')->name('profile.update');
Route::get('biography', 'UserController@fetchBiography')->middleware('auth')->name('biography');
Route::post('biography', 'UserController@updateBiography')->middleware('auth')->name('biography.update');
Route::post('headshot', 'UserController@updateHeadshot')->middleware('auth')->name('headshot.update');

Route::name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', 'AdminUserController');
    Route::get('users/{user}/biography', 'AdminUserController@fetchBiography')->middleware('auth')->name('biography');
    Route::post('users/{user}/biography', 'AdminUserController@updateBiography')->middleware('auth')->name('biography.update');
    Route::post('users/{user}/headshot', 'AdminUserController@updateHeadshot')->middleware('auth')->name('headshot.update');
});
    

