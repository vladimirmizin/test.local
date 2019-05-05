<?php

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('get-regions', 'AuthController@getRegions');
    Route::get('get-cities', 'AuthController@getCities');
    Route::group(['middleware' => 'auth:api'], function () {
//        Route::get('dashboard', function () {
//            return res()->json(['data' => 'Test Data']);
//        });
        Route::post('me', 'AuthController@me');
        Route::post('comment/save', 'CommentController@store');
        Route::get('comment/show', 'CommentController@index');
        Route::post('comment/update/{id}', 'CommentController@update');
        Route::get('comment/delete/{id}', 'CommentController@delete');
        Route::post('comment/savesub', 'CommentController@addSubComment');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');

    });
});