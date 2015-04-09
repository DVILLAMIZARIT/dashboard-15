<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Seeder\DatabaseSeeder;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('description')->unique();
			$table->timestamps(); 
		});
		
		Artisan::call('db:seed', array('--class' => 'RoleTableSeeder'));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}
	
}
