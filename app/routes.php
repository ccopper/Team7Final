<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('Login');
});

Route::post('/Login', function()
{
	if(Auth::attempt(array('UserName'=>Input::get('UserName'), 'password'=>Input::get('Password')))) 
	{
		return View::make('StudentInfo')->with('student', Auth::user()->Student);
	} else 
	{
		return View::make('Login');
	}
});