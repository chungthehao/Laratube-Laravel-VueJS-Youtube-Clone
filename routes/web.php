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
Route::resource('/channels', 'ChannelController');

Route::get('/videos/{video}', 'VideoController@show');
Route::put('/videos/{video}', 'VideoController@updateViews');
Route::put('/videos/{video}/update', 'VideoController@update')
    ->middleware(['auth'])
    ->name('videos.update');
Route::get('/videos/{video}/comments', 'CommentController@index');
Route::get('/comments/{comment}/replies', 'CommentController@getReplies');

Route::middleware(['auth'])->group(function () {
    Route::resource('/channels.subscriptions', 'SubscriptionController')->only(['store', 'destroy']);

    Route::get('/channels/{channel}/videos', 'UploadVideoController@index')->name('channels.upload-videos.index');
    Route::post('/channels/{channel}/videos', 'UploadVideoController@store')->name('channels.upload-videos.store');

    Route::post('votes/{video}/{type}', 'VoteController@vote');

});