<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Thread;
use App\Role;
use App\User;
use Carbon\Carbon;
use App\Http\Requests\CreateThreadRequest;
use Illuminate\Http\Request;

class ThreadController extends Controller {

	public function __construct()
	{
		//$this->middleware('auth',['except' =>'show,']);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return "Error should not be able to reach this page";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{	
		return $request->all();
		$aThread= new Thread;
		$aThread->Content = $request->Content;
		$aThread->userid = \Auth::id();
		$aThread->created_at= Carbon::now();
		
		return view('Thread.create')->with('aThread',$aThread1);
	}

	/**
	 * Store a newly created resource in storage.
	 *	$request : $id is the ID of the Conversation !
	 * @return Response
	 */
	public function store(CreateThreadRequest $request)
	{
	
		$thread = new Thread;
		 
		// if the user is logged
		if(\Auth::id())
		{
			$thread->user_id=\Auth::id();
		}
		//if the user is not logged he will be registered as a visitor
		else
		{
			$role=Role::select("*")->where('description','=','visitor')->get();
			$user=User::select("*")->where('role_id','=',$role[0]->id)->get();
			$thread->user_id=$user[0]->id;
		}
		
		$thread->Content=$request->Content;
		$thread->conversation_id=$request->id;
		$thread->created_at=Carbon::now();
		$thread->save();
		
		return redirect('Thread/'.$request->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id which is the id of the conversation
 	 * @return Response
	 */
	public function show($id)
	{
		$admin=Role::select('id')->where('description','=','admin')->firstOrFail();
		
		// if we are admin we want to see everything
			if(\Auth::id()==$admin->id)
			{	
				$listofMessages= User::select("*")->Join('threads', 'threads.user_id', '=', 'users.id')->where("threads.conversation_id",'=',$id)->get();							
			}
			else
			{
			// we are not admin but we want to see published messages and the status of our posted messages
				if(\Auth::guest())
				{		
					$listofMessages= User::select("*")->Join('threads', 'threads.user_id', '=', 'users.id')->where("threads.conversation_id",'=',$id)
									->where('threads.Pending','=',0)->get();
				}
				else
				{
					$listofMessages= User::select("*")->Join('threads', 'threads.user_id', '=', 'users.id')->where("threads.conversation_id",'=',$id)							
									->where('threads.Pending','=',0)
									->orwhere('threads.user_id','=',\Auth::id())
									->get();
				}
			}
			
		// We want the list of message related to this conversation with their writers
		//$listofMessages= Thread::select("*")->Join('users', 'Threads.user_id', '=', 'users.id')->where("threads.conversation_id",'=',$id)->get();
		return view('Thread')->with(['lstOfMessages'=>$listofMessages,'adminID'=>$admin]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{	
		$aThread= Thread::findOrFail($id);
		return view('Thread.edit')->with('aThread',$aThread);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
	
		$aThread = Thread::findOrFail($id);
	
		if($request->has('Content'))
		{	
			$aThread->update($request->all());
		}
		else
		{	
			if ($aThread->Pending == 0)
			{
				$aThread->Pending = 1;
			}
			else
			{
				$aThread->Pending = 0;
			}
			$aThread->save();
		}
		
		// We go back to the list of Threads for the current Conversation
		return redirect('Thread/'.$aThread->conversation_id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
