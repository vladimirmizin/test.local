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

Route::group(['middleware' => ['auth']], function () {
    Route::post('comment/add', 'CommentController@store')->name('add_comment');
    Route::get('delete/{id}', 'CommentController@destroy')->name('destroy_comment');
    Route::get('edit/{id}', 'CommentController@edit')->name('edit_comment');
    Route::post('update/{id}', 'CommentController@update')->name('comment.update');
});
