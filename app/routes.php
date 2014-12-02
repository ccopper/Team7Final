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
			return Redirect::to("/Admin");
		}
		return Redirect::to("/Student/Info");
	} else 
	{
		return View::make('Login');
	}
});
Route::get('/Logout', function()
{
	Auth::logout();

	return View::make('Login');

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
Route::get('/Admin', function()
{
	if(!Auth::check() || Auth::user()->PermissionLevel < 2) 
	{
		return View::make('AccessError');
	} 
	
	return View::make('Admin')->with('students', Student::All())->with('projects', Project::All());;
});
Route::get('/Project/TeamView', function()
{
	if(!Auth::check() || Auth::user()->PermissionLevel < 2) 
	{
		return View::make('AccessError');
	} 
	
	return View::make('TeamView')->with('projects', Project::All());;
});
Route::get('/Project/{id}', function($id)
{
	if(!Auth::check()) 
	{
		return View::make('AccessError');
	} 
	
	return View::make('Project')->with('project', Project::find($id));
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

Route::get('/Project/Assign/{id}/{sid}', function($id, $sid)
{
	
	$s = Student::find($sid);
	
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 
	if(Auth::user()->PermissionLevel < 2)
	{
		return "{ \"errCode\": 2 }";
	} 

	$s->ProjectID = $id;
	$s->save();
	
	return $s->toJson();
	
});

Route::get('/Project/UnAssign/{id}', function($id)
{
	
	$s = Student::find($id);
	
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 
	if(Auth::user()->PermissionLevel < 2)
	{
		return "{ \"errCode\": 2 }";
	} 

	$s->ProjectID = null;
	$s->save();
	
	return $s->toJson();
	
});

Route::get('/Admin/QVStudent/{id}', function($id)
{
	$s = Student::find($id);
	
	if(! (Auth::check())) 
	{
		return "{ \"errCode\": 1 }";
	} 
	if(Auth::user()->PermissionLevel < 2)
	{
		return "{ \"errCode\": 2 }";
	}
	
	$res = Array();
	$res["Student"] = $s;
	$res["Projects"] = $s->ProjectSelections()->get()->toArray();
	
	return json_encode($res);
});

Route::post('/Admin/StudentFile', function()
{

	if(!Auth::check() || Auth::user()->PermissionLevel < 2) 
	{
		return "{ \"errCode\": 1 }";
	}
	
	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	
	DB::statement("DELETE FROM Users WHERE PermissionLevel = 1");
	DB::statement("TRUNCATE TABLE Students");
	DB::statement("TRUNCATE TABLE Students_Projects");
	DB::statement("TRUNCATE TABLE Students_Prefer");
	DB::statement("TRUNCATE TABLE Students_Avoid");
	
	DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	
	$file = fopen($_FILES[0]['tmp_name'], "r");
	//First line is junk Skip
	$line = fgetcsv($file, 1024, ",");
	while (!feof($file)) 
	{
		$line = fgetcsv($file, 1024, ",");
		if(count($line) < 4)
			continue;
		DB::table('Users')->insert(array(
			array('CWID'=>trim($line[2]), 'UserName'=>trim($line[3]), 'Password'=>Hash::make(trim($line[2])), 'EMail'=>trim($line[3]), 'PermissionLevel'=>1)
		));
		DB::table('Students')->insert(array(
			array('CWID'=>trim($line[2]), 'FirstName'=>trim($line[0]), 'LastName'=>trim($line[1]), 'EMail'=>trim($line[3]))
		));
	}
	fclose($file);
		
	return json_encode(Student::all()->toArray());
	
});

Route::post('/Admin/ProjectFile', function()
{

	if(!Auth::check() || Auth::user()->PermissionLevel < 2) 
	{
		return "{ \"errCode\": 1 }";
	}
	
	DB::statement('SET FOREIGN_KEY_CHECKS=0;');

	DB::statement("TRUNCATE TABLE Students_Projects");
	DB::statement("TRUNCATE TABLE Projects");
	DB::statement("UPDATE Students SET ProjectID = NULL");
	
	DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	
	$file = fopen($_FILES[0]['tmp_name'], "r");
	$line = fgetcsv($file, 1024, ",");
	while (!feof($file)) {
		$line = fgetcsv($file, 1024, ",");
		if(count($line) < 4)
			continue;
		DB::table('Projects')->insert(array(
			array('ProjectName'=>$line[1], 'Company'=>$line[0], 'MinStudents'=>$line[2], 'MaxStudents'=>$line[3])
		));
	}
	fclose($file);
	
	return json_encode(Project::all()->toArray());
	
});

Route::get('/Admin/GenAssign', function()
{
	if(!Auth::check() || Auth::user()->PermissionLevel < 2) 
	{
		return "{ \"errCode\": 1 }";
	}
	//$s = Student::find(772233);
	//$p = Project::find(21);
	
//	return "F:".calcAvoid($s, $p);
	
	//Remove all existing assignments
	DB::statement("UPDATE Students SET ProjectID = NULL");
	
	
	//Process Project Preference People	
	$unStu = Student::whereNull('ProjectID')->where('PreferProjects', '=', '1')->orderByRaw("RAND()")->get();
	
	$unStu->each(function($s)
	{
		assignViaProject($s);
	});
	//Process Partner Preference People	
	$unStu = Student::whereNull('ProjectID')->where('PreferProjects', '=', '0')->orderByRaw("RAND()")->get();
	
	$unStu->each(function($s)
	{
		assignViaPartner($s);
	});
	$unStu = Student::whereNull('ProjectID');
	
	DB::statement("UPDATE Students SET ProjectID = null WHERE ProjectID = -1");
	//Process Filler Preference(ulucky too) People	
	$unStu = Student::whereNull('ProjectID')->orderByRaw("RAND()")->get();
	
	$unStu->each(function($s)
	{
		foreach(Project::all() as $p)
		{
			if($p->AssignedStudents->count() > 0)
			{
				if(attemptAssign($s, $p))
				{
					break;
				}
			}
		}
		if(isset($s->ProjectID)) { return; } 
		foreach(Project::all() as $p)
		{
			if(attemptAssign($s, $p))
			{
				break;
			}
		}
	});
	
	
	return "{ \"errCode\": 5 }";
});

function assignViaProject($s, $isNew = true)
{
	foreach($s->ProjectSelections as $project)
	{
		if(attemptAssign($s, $project))
			break;
	}
	if(!isset($s->ProjectID) && !$isNew)
	{
		assignViaPartner($s);
	}
	if(!isset($s->ProjectID))
	{
		//Make Filler
		$s->ProjectID = -1;
	}
	$s->save();
}

function assignViaPartner($s)
{
	$minA = 9999;
	$minP = null;
	foreach($s->PrePartners as $friend)
	{
		$A = calcAvoid($s, $friend->Assignment());
		if($A == 0)
			if(attemptAssign($s, $friend->Assignment()))
				break;
		else
		{
			if($minA > $A)
			{
				$minA = $A;
				$minP = $friend->Assignment();
			}
		}
	}
	if(!isset($s->ProjectID))
	{
		attemptAssign($s, $minP);
	}
	if(!isset($s->ProjectID))
	{
		assignViaProject($s, false);
	}
	if(!isset($s->ProjectID))
	{
		$s->ProjectID = -1;
	}
	
}

function calcAvoid($s, $p)
{
	$c = 0;
	
	foreach($s->AvoidPartners as $ap)
	{
		$c += (($p->AssignedStudents->contains($ap->CWID))? 1 : 0);
	}
	foreach($p->AssignedStudents as $as)
	{
		$c += (($as->AvoidPartners->contains($s->CWID))? 1 : 0);
	}
	
	return $c;
}

function attemptAssign($stu, $proj)
{
	$c = $proj->AssignedStudents->count();

	if($c >= $proj->MaxStudents)
		return false;
	$stu->ProjectID = $proj->id;
	$stu->save();
	return true;
}


?>
