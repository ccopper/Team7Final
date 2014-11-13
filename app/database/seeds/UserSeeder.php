<?php

class UserSeeder extends Seeder 
{
	public function run()
	{
		DB::table('Users')->insert(array(
			array('CWID'=>1, 'UserName'=>"admin", 'Password'=>"admin", 'EMail'=>"none", 'PermissionLevel'=>2 ),
		));
	}	
}

?>