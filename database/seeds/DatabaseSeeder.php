<?php

use App\Role;
use App\User;
use App\Conversation;
use App\Thread;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\CreateConversationRequest;

class RoleTableSeeder extends Seeder {

	public function run()
	{
		DB::table('roles')->delete();
/*		$role = new Role();
		$role->description="admin";
		$role->save();
		
		$role = new Role();
		$role->description="guest";
		$role->save();
		
		$role = new Role();
		$role->description="visitor";
		$role->save();
	*/	
		Model::unguard();
		Role::create(['description'=> "admin"]);
		Role::create(['description'=> "guest"]);
		Role::create(['description'=> "visitor"]);
	}
}

class UserTableSeeder extends Seeder {
	
	public function run()
	{
		Model::unguard();
		DB::table('users')->delete();
		// we create the admin 
		$admin = DB::table('roles')->where('description','admin')->get();
		User::create(['name'=> 'admin','email'=>"Admin@test.com",'password'=>Hash::make('admin'),'role_id'=> $admin[0]->id]);
		
		// we generate the visitor 
		$visitor = DB::table('roles')->where('description','visitor')->get();
		User::create(['name'=> 'visitor','email'=>"visitor@test.com",'password'=>Hash::make('anything'),'role_id'=> $visitor[0]->id]);

	}
}

class ThreadTableSeeder extends Seeder{
	
	public function run()
	{
		Model::unguard();
		// MUST fail is have nothing
		$aConvID=Conversation::firstOrFail()->id;
		$userID=User::firstOrFail()->id;
		Thread::create(['Content'=> 'A Thread comment seeded','user_id'=>$userID ,'conversation_id'=>$aConvID]);
		
	}
}

class ConversationSeeder extends Seeder {
	
	public function run()
	{
		Model::unguard();
		DB::table('conversations')->delete();
		
		$request =new CreateConversationRequest();
		$request->Title="Demonstration: Conversation level contain title";
		$request->Content="Demonstration: Thread level contain content";
		$request->Pending=false;
		Conversation::customCreate($request);	
		
		/* roughly equivalent to the following instructions without selection the first user available
		// Take the first ID in the table
		$user=User::first()->id;
		// We create the conversation
		$aConv=Conversation::create(['Title'=> "Demonstration: Conversation level contain title",
							  'user_id'=> $user,
							  'Pending'=>false]);
							  
		// We create the first Thread of the Conversation		
		Thread::create(['Content'=> "Demonstration: Thread level contain content",
							  'user_id'=> $user,
							  'Pending'=>false,
							  'conversation_id'=>$aConv->id]);
		*/
					  
	}

}

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->call('RoleTableSeeder');	
		$this->call('UserTableSeeder');
		$this->call('ConversationSeeder');
		$this->call('ThreadTableSeeder');
	}
} 