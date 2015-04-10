@extends('template')
@section('content')

@if(count($lstOfMessages) >0)
<table frame="border" border="2" class="table table-hover">
{{-- We get all the messages related to the current conversation --}}

@foreach($lstOfMessages as $amsg)

	<tr class="active">
		<td> Author : {{$amsg->name}}<br>
		     Date :  {{$amsg->created_at}}</td>
	<th>{{$amsg->Content}}
		
	{!! Form::open(['method'=>'PATCH', 'action' =>['ThreadController@update', 'id'=> $amsg->id],'class'=>'form-group']) !!} 
		@if(\Auth::id()==$amsg->user_id || \Auth::id()==$adminID->id)
		<th>
			<a href="/Thread/{{$amsg->id}}/edit">Edit</a>
		</th>
		@endif
		{{-- if we are admin we can publish pending messages --}}
				@if(\Auth::id()==$adminID->id)
				<th>
					@if($amsg->Pending==1)
						{!! Form::submit('pending', ['class' =>"btn btn-primary btn-xs"]) !!}
					@else
						{!! Form::submit('published', ['class' =>"btn btn-primary btn-xs"]) !!}
					@endif
				@else
					@if($amsg->Pending==1)
						{!! Form::submit('waiting for approval', ['class' =>"btn btn-primary btn-xs", 'disabled'=>'']) !!}
					@else
						{!! Form::submit('validated by admin', ['class' =>"btn btn-primary btn-xs",'disabled'=>'']) !!}
					@endif
				</th>
				@endif
		
	{!! Form::close() !!}
	</th>	
	</tr>
@endforeach
</table>

{!! Form::open(['method'=>'POST','action'=>["ThreadController@store",'id' => $lstOfMessages[0]->conversation_id], 'class'=>'form-group']) !!} 

<div class="container">
	@if(!\Auth::check())
	<div class="row">
		<div class="col-lg-4">
			{!! Form::label('Visitor',"Your name") !!}
			{!! Form::text('Visitor','',['class' => 'form-control']) !!}
		</div>
	</div>
	@endif
	<div class="row">
		<div class="col-lg-8">
		{!! Form::text('Content',null,['class' => "form-control"]) !!}
		{!! Form::submit('Add a Comment',['class' => "btn btn-primary"]) !!}
		{!! Form::close() !!}
		</div>
	</div>
</div>
<a href="../Dashboard"> Go Back </a>

@else
{{!! Form::label("All threads are pending or the Administrator unpublished every Threads")!!}}
<br>{{!! Form::label("Please contact your Administrator")!!}}</center>
@endif

@stop