<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Thread;
use Carbon\Carbon;
use App\Http\Requests\CreateConversationRequest;


class Conversation extends Model {
     
	//
	protected $fillable=
	[
		'Title',
		'Author',
		'DateofCreations'
	];
	
	public function scopePublished($query)
	{
		$query->where('published_at','<',Carbon::now());
	}
	
	public function scopePending($query)
	{
		$query->where('Pending','=',true);
	}
	
	public function Threads()
	{
		return $this->hasMany('App\Thread');
	}
	
	// to be sure that Conversation and Threads are created the right way
	// input : must contain all the required fields Title and Content
	public static function customCreate(CreateConversationRequest $request)
	{
		$conv = new Conversation;
		$conv->Title = $request->Title;
		
		// if nothing specified in the request
		if(!$request->has('user_id'))
		{	// if we are not even logged ( happen while seeding base)
			if(!\Auth::check())
			{
				$conv->user_id=User::first()->id;
			}
			// logged 
			else
			{	 
				$conv->user_id=\Auth::id();
			}
		}

		$conv->created_at= Carbon::now();
		$conv->save();
		
		// When conversation is settled the Thread can be created
		$thread= new Thread;
		$thread->user_id=$conv->user_id;	
		$thread->Content=$request->Content;
		$thread->conversation_id=$conv->id;
		$thread->created_at=Carbon::now();
		$thread->save();
		
		return true;
	}
	
	
}
