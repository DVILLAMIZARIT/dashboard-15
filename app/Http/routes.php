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
	$query="";
	// test of the query parameter
	if($keys['query']!="")
	{
		$query=Conversation::where("Title","like","%".$keys['query']."%");//->skip($keys['offset']);//->get();
	}
	else
	{
		$query=Conversation::select("*");	
	}

	//test of the offset parameter
	if($keys['offset']!=0)
	{
		$query=$query->take($keys['limit'])->skip($keys['offset'])->get();
	}
	else
	{
		$query=$query->get();
	}
	
	//else
	//{	// cannot use offset alone, so we take a limit very high 
	//	$query=Conversation::select("*")->take(9999999)->skip($keys['offset'])->get();
		// we do not want so much be we still need to know how much answer we get
	//}
	
	
	$i=0;
	$response=array();
	
	
	foreach($query as $qry)
	{
		if($i<$keys['limit'])
		{	
			$i=$i+1;
			array_push($response,$qry); 
			//return response()->json($query);		
		}
		//else
		//{
			//return $response;
			//return response()->json($query);
			//$fakeConversation = new Conversation();
			//$fakeConversation->Title=intval($i);
			//array_push($response,$fakeConversation); 
			//return $response;
			//break;
//}
	}
	
	$fakeConversation = new Conversation();
	$fakeConversation->Title=$query->count();
	array_push($response,$fakeConversation); 
	return $response;	

	//return response()->json($query);

});

//Route::resource('control','DashboardController');
Route::resource('Dashboard','DashboardController');
Route::resource('Thread','ThreadController');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
