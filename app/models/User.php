<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface {

	use UserTrait, RemindableTrait;

	public $table = 'Users';
	public $timestamps = false;
	public $hidden = array('Password');

	public function getAuthIdentifier() 
	{
		return $this->getKey();
	}
	
	public function getAuthPassword() 
	{
		return $this->Password;
	}

	public function Student()
	{
		return $this->hasOne('Student', 'CWID', 'CWID');
	}
	
	public function owns(Student $s)
	{
		return $this->CWID == $s->CWID;
	}

	public function canEdit(Student $s)
	{
		return ($this->PermissionLevel > 1) || $this->owns($s);
	}
	
}
