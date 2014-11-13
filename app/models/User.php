<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'Users';
	protected $timestamps = false;
	protected $hidden = array('password', 'remember_token');

	public function getAuthIdentifier() 
	{
		return $this->getKey();
	}
	
	public function getAuthPassword() 
	{
		return $this->password;
	}

	public function Student()
	{
		return $this->hasMany('Student');
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
