<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model {
	protected $fillable =
	[
			'Content','Author','Conversation','created_at'
	];
	
	public function Conversation()
	{
		return $this->belongsTo('App\Conversation');
	}
	
	public function getConversationTitle()
	{
		return isset($this->Conversation->Title) ? $this->Conversation->Title : '';
	}

}
