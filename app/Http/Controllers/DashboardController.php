<?php 
namespace App\Http\Controllers;

use App\Conversation;
use App\Thread;
use App\User;
use App\Role;
use App\Http\Requests\CreateConversationRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller {

	/**
	 * Constructor
	 * 
	 * 
	 */
	public function __construct()
	{
		$this->middleware('auth',['except' =>'index']);
	}
	
	
	/**
	 * Display a listing of the resource.
	 * Display every conversation/topics with the first Thread related
	 * @return Response
	 */
	public function index()
	{
		
		$Threads=array();
		$Result= array();
		$count=0;
		$admin = Role::select('id')->where('description','=','admin')->firstorFail();
	
		// if we are admin we want to see everything
		if(\Auth::id()==$admin->id)
		{	
			$Conversations= User::select('*')->join('conversations','conversations.user_id','=','users.id')->get();
		}
		else
		{
		// we are not admin but we want to see published messages and the status of our posted messages
			
			if(\Auth::guest())
			{
				$Conversations= User::select('*')->join('conversations','conversations.user_id','=','users.id')
											 ->where('conversations.Pending','=',0)->get();
			}
			else
			{
				
				$Conversations= User::select('*')->join('conversations','conversations.user_id','=','users.id')
											 ->where('conversations.Pending','=',0)
											 ->orwhere('conversations.user_id','=',\Auth::id())
											 ->get();
			}
		}
		
	
		// we recover the first Thread according to the conversations which passed the previous tests
		foreach($Conversations as $Conversation)
		{
			$Threads[$count]= Thread::where('conversation_id','=',$Conversation->id)->firstOrFail();
			$Result[$count] = array ( $Conversation, $Threads[$count]);
			$count++;
		}
		
		
		return view('Dashboard')->with(['dashboard'=>$Result,'adminID' =>$admin]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('Dashboard.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateConversationRequest $request)
	{
	
	// Auth::user()->articles()->save(new Article($request->all()));
		$conv = new Conversation;
		$conv->Title = $request->Title;
		$conv->user_id=\Auth::id();
		$conv->created_at= Carbon::now();
		$conv->save();
		
		$thread= new Thread;
		$thread->user_id=\Auth::id();	
		$thread->Content=$request->Content;
		$thread->conversation_id=$conv->id;
		$thread->created_at=Carbon::now();
		$thread->save();
		
		// create a session for this flash message 
		session()->flash('flash_message', 'Conversation created and waiting for approval');
		return redirect('Dashboard');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// we show the conversation and the first Thread related to it
		$aConv = Conversation::findOrFail($id);
		$aThread = Thread::select("*")->where("user_id",'=',$id)->get();
		return "DEAD END";
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//guest shouldn't be able to reach this page
		// but just in case....
		if(\Auth::guest())
		{ 
			//return redirect('Dashboard') ;
		}
		
		$aConv= Conversation::findOrFail($id);
		$aThread = Thread::select("*")->where("conversation_id",'=',$id)->firstOrFail()->get();
		
		
		
		return view('Dashboard.edit')->with(['aConv' => $aConv, 'aThread' =>$aThread]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$aConv=Conversation::findOrFail($id);
		$aThread = Thread::select("*")->where("conversation_id",'=',$id)->firstOrFail();
		if($request->has('Content'))
		{
			$aConv->update($request->all());
			session()->flash('flash_message', 'Conversation updated');
		}
		else
		{
			
			// by definition if the conversation is validated the first thread also is
			if($aConv->Pending ==1)
			{
				$aConv->Pending=0;
				$aThread->Pending=0;
				session()->flash('flash_message', 'Conversation is now published');
			}
			else
			{
				$aConv->Pending=1;
				$aThread->Pending=1;
				session()->flash('flash_message', 'Conversation is now unpublished');
			}
			
			
		}
		
		$aConv->save();
		$aThread->save();
		
		
		
		return redirect('Dashboard');
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
