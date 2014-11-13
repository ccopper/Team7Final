<?php

class Student extends Eloquent
{
	protected $table = 'Students';
	protected $fillable = array('CWID', 'FirstName', 'LastName', 'EMail', 'Major','Minor', 'OtherInfo', 'PreferProjects');
	protected $timestamps = false;
	
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