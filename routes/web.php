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

Route::get('nexmo', function()
{
	$user = App\User::first();
	$task = App\Task::first();

	$user->notify(new App\Notifications\TaskCreated($task));

});

Route::group(['middleware'=>'auth'], function()
{
		Route::resource('tasks', 'TasksController');
		Route::get('/', 'HomeController@index');
});


Auth::routes();
