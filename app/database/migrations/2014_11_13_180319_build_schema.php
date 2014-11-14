<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuildSchema extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Users', function($table)
		{
			$table->integer('CWID');
			$table->string('UserName');
			$table->string('Password');
			$table->string('EMail');
			$table->integer('PermissionLevel');
			$table->string('remember_token')->nullable();
			
			$table->primary('CWID');
		});
		Schema::create('Students', function($table)
		{
			$table->integer('CWID');
			$table->string('FirstName');
			$table->string('LastName');
			$table->string('EMail');
			$table->string('Major')->nullable();
			$table->string('Minor')->nullable();
			$table->string('OtherInfo')->nullable();
			$table->integer('PreferProjects')->default(1);
			$table->integer('ProjectID')->nullable();
			
			$table->primary('CWID');
		});
		Schema::create('Students_Projects', function($table)
		{
			$table->integer('CWID');
			$table->integer('ProjectID');
			$table->integer('Priority');
			
			$table->primary(array('CWID', 'ProjectID'));
		});
		Schema::create('Projects', function($table)
		{
			$table->increments('id');
			$table->string('ProjectName');
			$table->string('Company');
			$table->integer('MaxStudents');
			$table->integer('MinStudents');
			
		});
		Schema::create('Students_Avoid', function($table)
		{
			$table->integer('CWID');
			$table->integer('CWID_Avoid');
			
			$table->primary(array('CWID', 'CWID_Avoid'));
		});
		Schema::create('Students_Prefer', function($table)
		{
			$table->integer('CWID');
			$table->integer('CWID_Prefer');
			
			$table->primary(array('CWID', 'CWID_Prefer'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('Users');
		Schema::dropIfExists('Projects');
		Schema::dropIfExists('Students');
		Schema::dropIfExists('Students_Projects');
		Schema::dropIfExists('Students_Avoid');
		Schema::dropIfExists('Students_Prefer');
		
	}

}
