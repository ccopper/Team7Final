<?php

class Student extends Eloquent
{
	public $table = 'Students';
	protected $primaryKey = 'CWID';
	public $fillable = array('CWID', 'FirstName', 'LastName', 'EMail', 'Major','Minor', 'OtherInfo', 'PreferProjects');
	public $timestamps = false;
	
	public function PrePartners()
	{
		return $this->belongsToMany('Students', 'Students_Preferred', 'CWID', 'ProjectID');
	}
	
	public function Projects()
	{
		return $this->belongsToMany('Projects', 'Students_Projects', 'CWID', 'ProjectID');
	}
	
	public function Assignment()
	{
		return $this->hasOne('Project', 'id', 'ProjectID');
	}
	
}

?>