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

Route::get('/', 'IndexController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/test', 'IndexController@postShow')->name('uploader');
Route::any('/upload-handler', 'IndexController@uploader')->name('upload_handler');
Route::get("tbm-images/{filename}", 'IndexController@imageTmb')->name('image_thumb')->where('filename', '.*');
Route::get("norm-images/{filename}", 'IndexController@imageNormal')->name('image_normal')->where('filename', '.*');
