@extends ('template')

@section ('content')

@foreach($dashboard as $adash)

{!! Form::open(['method'=>'PATCH', 'action' =>['DashboardController@update', $adash[0]->id]]) !!} 

	<div class="panel panel-default">
		<div class="panel-heading">
		<div class="row">     	
			<div class="col-md-8">
				<a href="/Thread/{{$adash[0]->id}}"> {{ $adash[0]->Title }} </a> 
				<br>Author : {{ $adash[0]->name }}
			</div>
			<div class="col-md-4">
				{{-- if we are the original write of the message or the admin we can edit it --}}
				@if(\Auth::id()==$adash[0]->user_id ||\Auth::id()==$adminID->id)
					<a href="/Dashboard/{{$adash[0]->id}}/edit">Edit</a> 
				@endif
				
				{{-- if we are admin we can publish pending messages --}}
				@if(\Auth::id()==$adminID->id)
					@if($adash[0]->Pending==1)
						{!! Form::submit('pending', ['class' =>"btn btn-primary btn-xs"]) !!}
					@else
						{!! Form::submit('published', ['class' =>"btn btn-primary btn-xs"]) !!}
					@endif
				@else
					@if($adash[0]->Pending==1)
						{!! Form::submit('waiting for approval', ['class' =>"btn btn-primary btn-xs", 'disabled'=>'']) !!}
					@else
						{!! Form::submit('validated by admin', ['class' =>"btn btn-primary btn-xs",'disabled'=>'']) !!}
					@endif
				@endif
			</div>
		</div>
		</div>
		<div class="panel-body">
			<div class="row"> 
			<div class="col-md-8">
			{!! Form::label('body',$adash[1]->Content) !!}
			</div>
			</div>
		</div>
	</div>

{!! Form::close() !!}
	
@endforeach
<div class="col-md-8">
<a href="Dashboard/create"> add a new Conversation </a>
</div>
@stop