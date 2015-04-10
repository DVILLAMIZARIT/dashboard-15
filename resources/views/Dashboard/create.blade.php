@extends('template')

@section('content')

{!! Form::open(['url' => 'Dashboard']) !!}
<div class="form-group">
	{!! Form::label('Title','Title: ') 		!!}
	{!! Form::text('Title', null, ['class' => 'form-control']) !!}<p>
	{!! Form::label('Content','Content: ') 	!!}
	{!! Form::textarea('Content', null, ['class' => 'form-control'])!!}
	{!! Form::submit('Submit',['class' => 'btn btn-primary'])!!}
</div>	
{!! Form::close() !!}
@stop