<?php

class Project extends Eloquent
{
	public $table = 'Projects';
	protected $primaryKey = 'id';
	public $fillable = array('id', 'ProjectName', 'Company', 'MinStudents', 'MaxStudents');
	public $timestamps = false;
	
	public function AssignedStudents()
	{
		return $this->hasMany('Student', 'ProjectID', 'id');
	}
}

?>