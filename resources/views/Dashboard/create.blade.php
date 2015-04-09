@extends('template')
Dashboard Create page
@section('content')

{!! Form::open(['url' => 'Dashboard']) !!}
<div class="form-group">
	{!! Form::label('Title','Title: ') 		!!}
	{!! Form::text('Title', null, ['class' => 'form-control']) !!}<p>
	{!! Form::label('Content','Content: ') 	!!}
	{!! Form::textarea('Content', null, ['class' => 'form-control'])!!}
	{!! Form::submit('Submit',['class' => 'form-control'])!!}
</div>	
{!! Form::close() !!}
@stop