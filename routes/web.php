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
    Route::post('update/{id}', 'CommentController@update')->name('update_comment');
    Route::post('add-sub-comment/{parent_comment_id?}/{title?}', 'CommentController@addSubComment')->name('add_sub_comment');
    Route::get('countries', 'Auth/RegisterController@countries')->name('countries');
    Route::get('region/{region_id}','Auth/RegisterController@get_regions')->name('get_regions');
    Route::get('city/{city_id}','Auth/RegisterController@get_city')->name('get_city');

});
