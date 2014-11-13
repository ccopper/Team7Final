<?php

class UserSeeder extends Seeder 
{
	public function run()
	{
		DB::table('Users')->insert(array(
			array('CWID'=>1, 'UserName'=>"admin", 'Password'=>Hash::make('admin'), 'EMail'=>"none", 'PermissionLevel'=>2 ),
		));
		DB::table('Students')->insert(array(
			array('CWID'=>1, 'FirstName'=>"admin", 'LastName'=>"istrator", 'EMail'=>"none" ),
		));
	}	
}

?>