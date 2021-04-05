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

Route::name('upload.')->prefix('uploadfile')->group(function() {
    Route::get('/', 'UploadFileController@index')->name('index');
    Route::post('/', 'UploadFileController@store')->name('store');
    Route::get('/download/{uploadfile:url}', 'UploadFileController@show')->name('download');
});
