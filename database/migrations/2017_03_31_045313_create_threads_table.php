<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateThreadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('threads', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('Content');
			$table->boolean('Pending')->default(true);
			$table->integer('user_id')->unsigned();
			$table->integer('conversation_id')->unsigned();
			$table->timestamps('created_at'); // will be automatically changed by migration
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('conversation_id')->references('id')->on('Conversations')->onDelete('cascade');
			
		});
		
		Artisan::call('db:seed', array('--class' => 'ConversationSeeder'));
		Artisan::call('db:seed', array('--class' => 'ThreadTableSeeder'));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('threads');
	}

}
