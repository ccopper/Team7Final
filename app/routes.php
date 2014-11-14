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


/*
	JSON Routes
	
	These are for AJAX calls from javascript
*/

Route::post('/Student/Update/{id}', function($id)
{
	$s = Student::find($id);
	
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 
	if(!Auth::user()->canEdit($s))
	{
		return "{ \"errCode\": 2 }";
	} 
	
	$okFields = array("Major", "Minor", "OtherInfo", "PreferProjects"); 
	
	if(!in_array(Input::get("fieldName"), $okFields))
	{
		return "{ \"errCode\": 3 }";
	}
	
	$s[Input::get("fieldName")] = Input::get("fieldValue");
	$s->save();
	
	return "{ \"errCode\": 0 }";
	
});

Route::post('/Student/Find', function ()
{
	$n = Input::get("Name");
	return json_encode(Student::where("FirstName", "LIKE", $n."%")->get()->toArray());
});


Route::get('/Student/Prefer/{id}/{pid}', function($id, $pid)
{
	$s = Student::find($id);
	
	if($id == $pid)
	{
		return;
	}
	
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 
	if(!Auth::user()->canEdit($s))
	{
		return "{ \"errCode\": 2 }";
	} 

	$s->PrePartners()->attach($pid);
	
	return Student::find($pid)->toJson();
	
});

Route::get('/Student/UnPrefer/{id}/{pid}', function($id, $pid)
{
	$s = Student::find($id);
	
	if($id == $pid)
	{
		return;
	}
	
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 
	if(!Auth::user()->canEdit($s))
	{
		return "{ \"errCode\": 2 }";
	} 

	$s->PrePartners()->detach($pid);
	
	return "{ \"errCode\": 0 }";
	
});



