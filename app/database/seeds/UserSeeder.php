<?php
class UserSeeder extends Seeder
{
	public function run()
	{

		$file = fopen("Students.csv", "r");
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
		
		DB::table('Users')->insert(array(
			array('CWID'=>1, 'UserName'=>"admin", 'Password'=>Hash::make("admin"), 'EMail'=>"none", 'PermissionLevel'=>2 )
		));


	}
}
?>