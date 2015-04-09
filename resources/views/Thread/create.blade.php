@extends('template')
Thread create page returned by ThreadController@create
 
@section('content')

{!! Form::open(['url' => 'Thread']) !!}
<div class="form-group">
	{!! Form::label('Content','Content: ') 	!!}
	{!! Form::textarea('Content', null, ['class' => 'form-control'])!!}
	{!! Form::submit('Submit',['class' => 'form-control'])!!}
</div>	
{!! Form::close() !!}

@stop