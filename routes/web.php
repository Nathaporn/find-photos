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

Route::get('/profile/history', 'UserController@history')->name('history');
Route::get('/profile/history/{id}', 'UserController@history_detail');
Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/profile', 'UserController@update_profile');
Route::get('/profile/update', 'UserController@edit_profile')->name('editprofile');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@upload');
Route::post('/home/search', 'HomeController@search')->name('search');
Route::post('/searchagain', 'HomeController@search_again')->name('search_again');

Route::get('/feedback', 'FeedbackController@index')->name('feedback');
Route::post('/feedback', 'FeedbackController@receiveFeedback')->name('sendFeedback');
