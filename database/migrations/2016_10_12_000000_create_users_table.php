<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Seeder\DatabaseSeeder;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// we seed the user table
		
		Schema::create('users', function(Blueprint $table)
		{
			$guestDefaultID=DB::table('roles')->where('description','guest')->get();
			$table->increments('id');
			// we dynamicaly generate default value according to id generated while creating roles table
			$table->integer('role_id')->unsigned()->default($guestDefaultID[0]->id);
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->rememberToken();
			$table->timestamps();
			$table->foreign('role_id')->references('id')->on('roles');
		});
		//artisan db:seed --class=UserTableSeeder;
		Artisan::call('db:seed', array('--class' => 'UserTableSeeder'));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
