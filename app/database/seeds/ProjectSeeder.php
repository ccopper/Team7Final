<?php
class ProjectSeeder extends Seeder
{
	public function run()
	{
		$file = fopen("Projects.csv", "r");
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

	}
}
?>