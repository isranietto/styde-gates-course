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

Route::post('/admin/posts', 'Admin\PostController@store')->middleware('auth');
Route::put('/admin/posts/{post}', 'Admin\PostController@update')->middleware('auth');


Route::name('login')->get('login', function (){
    return 'Login';
});