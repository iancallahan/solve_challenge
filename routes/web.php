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
Route::get('/profile', 'UserController@edit')->name('profile');

Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    Route::get('users', 'AdminUserController@index')->name('user.index');
    Route::get('user/create', 'AdminUserController@create')->name('user.create');
    Route::post('user/create', 'AdminUserController@store')->name('user.store');
    Route::get('user/{id}', 'AdminUserController@edit')->name('user.edit');
    Route::post('user/{id}', 'AdminUserController@update')->name('user.update');
});
    

