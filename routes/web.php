<?php

use Illuminate\Support\Facades\Route;

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

// Main page
Route::get('/', 'CommentsController@show');

// Get last five comments
Route::get('/comments', 'CommentsController@retrieveComments');

// Create a new comment
Route::post('/comments/create', 'CommentsController@createComment');
