<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateConversationRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		   'Title' => 'required|min:1',
		   'Content' => 'required|min:8'
		];
			   // the content is not mandatory for a conversation
		   // but the message linked to this conversation must have some content
	
	}

}
