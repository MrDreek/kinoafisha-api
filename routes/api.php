<?php

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


Route::post('get-code','Api@getCode')->name('get-code');
Route::post('get-seances','Api@getSchedule')->name('get-seances');
Route::post('get-movie-detail','Api@getMovieDetail')->name('get-movie-detail');

Route::get('get-city-list','Api@getCityList')->name('city-list');
