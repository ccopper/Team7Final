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

Route::get('/AccessError', function()
{
	return View::make('AccessError');
});


Route::post('/Login', function()
{
	if(Auth::attempt(array('UserName'=>Input::get('UserName'), 'password'=>Input::get('Password')))) 
	{
		if(Auth::user()->PermissionLevel > 1)
		{
			return Redirect::to("/Student/Info/".Student::All()->first()->CWID);
		}
		return Redirect::to("/Student/Info");
	} else 
	{
		return View::make('Login');
	}
});

Route::get('/Student/Info/{id?}', function($id = null)
{
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 

	if(isset($id))
	{
		$s = Student::find($id);
	} else
	{
		$s = Auth::user()->Student;
	}
	
	if(!Auth::user()->canEdit($s))
	{
		return View::make('AccessError');
	} 
	
	return View::make('StudentInfo')->with('student', $s)->with('projects', Project::All());
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

Route::get('/Student/Avoid/{id}/{pid}', function($id, $pid)
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

	$s->AvoidPartners()->attach($pid);
	
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
	
	return Student::find($pid)->toJson();
	
});

Route::get('/Student/UnAvoid/{id}/{pid}', function($id, $pid)
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

	$s->AvoidPartners()->detach($pid);
	
	return Student::find($pid)->toJson();
	
});

Route::get('/Student/ProjectSelect/{id}/{pid}/{pri}', function($id, $pid, $pri)
{
	$maxProj = 4;
	$oldPri = $maxProj+1;
	
	$s = Student::find($id);
	
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 
	if(!Auth::user()->canEdit($s))
	{
		return "{ \"errCode\": 2 }";
	} 
	if($pri < 1 || $pri > $maxProj)
		{
		return "{ \"errCode\": 3 }";
	}
	
	$ps = $s->ProjectSelections()->where('Priority','=',$pri)->first();
	
	if(isset($ps))
	{	
		$s->ProjectSelections()->detach($ps);
		$s->save();
	}
	
	$ps = $s->ProjectSelections()->where('ProjectID','=',$pid)->first();

	if(isset($ps))
	{	
		$s->ProjectSelections()->updateExistingPivot($pid, array("Priority" => $pri));
	} else
	{
		$s->ProjectSelections()->attach($pid, array("Priority" => $pri));
		$s->save();
	}
	
	$s->save();

	
	return json_encode($s->ProjectSelections()->get()->toArray());
	
});

