<?php
use App\Conversation;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){return view('messages');});
Route::get('home', 'DashboardController@index');
Route::get('messages',function(Request $request)
{
	// we recover all the data sent by the ajax request
	$keys=$request::all();

	// test of the query parameter
	if($keys['query']!="")
	{
		$query=Conversation::where("Title","like","%".$keys['query']."%")->get();
	}
	else
	{
		$query=Conversation::all();	
	}

	//test of the limit parameter
	if($keys['limit']!=00)
	{
		$query=$query->take($keys['limit']);
	}

	
	return response()->json($query);
	
	
	/*//Conversation::all()->take(y)->skip(x)
	
	/**
	 * Determine if the request is the result of an AJAX call.
	 * @return bool
	 * public function ajax() // isEmptyString($key)
	 */
	
});

//Route::resource('control','DashboardController');
Route::resource('Dashboard','DashboardController');
Route::resource('Thread','ThreadController');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
