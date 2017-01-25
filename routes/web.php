<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('blog/{slug}', ['as'=> 'blog.single','uses' => 'BlogController@getSingle'])->where('slug','[\w\d\-\_]+');
// route for Authentication
Route::get('blog',['uses' => 'BLogController@getIndex','as' => 'blog.index']);
Route::get('contact', 'PagesController@getContact');
Route::post('contact', 'PagesController@getContact');
Route::get('about', 'PagesController@getAbout');
Route::get('/', 'PagesController@getIndex');
Route::resource('posts', 'PostController');
Route::resource('categories','CategoryController',['except' => ['create']]);
Route::resource('tags','TagController',['except' => ['create']]);
//Comments
Route::post('comments/{post_id}',['uses' => 'CommentsController@store', 'as' => 'comments.store']);
Route::get('comments/{id}/edit',['uses' => 'CommentsController@edit','as' => 'comments.edit']);
Route::put('comments/{id}',['uses' => 'CommentsController@update','as' => 'comments.update']);
Route::delete('comments/{id}',['uses' => 'CommentsController@destroy','as' => 'comments.destroy']);
Route::get('comments/{id}/delete',['uses' => 'CommentsController@delete','as' => 'comments.delete']);
Auth::routes();

Route::get('/auth/login', 'HomeController@index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
