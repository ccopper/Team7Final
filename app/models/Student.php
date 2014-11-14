<?php

class Student extends Eloquent
{
	public $table = 'Students';
	protected $primaryKey = 'CWID';
	public $fillable = array('CWID', 'FirstName', 'LastName', 'EMail', 'Major','Minor', 'OtherInfo', 'PreferProjects');
	public $timestamps = false;
	
	public function PrePartners()
	{
		return $this->belongsToMany('Student', 'Students_Prefer', 'CWID', 'CWID_Prefer');
	}
	
	public function AvoidPartners()
	{
		return $this->belongsToMany('Student', 'Students_Avoid', 'CWID', 'CWID_Avoid');
	}
	public function Projects()
	{
		return $this->belongsToMany('Project', 'Students_Projects', 'CWID', 'ProjectID');
	}
	
	public function Assignment()
	{
		return $this->hasOne('Project', 'id', 'ProjectID');
	}
	
}

?>