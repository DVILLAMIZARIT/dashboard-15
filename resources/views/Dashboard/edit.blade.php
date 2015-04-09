@extends('template')
@section('content')
{!! Form::model($aConv,['method' => 'PATCH','url' => "Dashboard/$aConv->id"]) !!}
<div class="form-group">
	{!! Form::label('Title','Title: ')!!}
	{!! Form::text('Title', null, ['class' => 'form-control']) !!}<p>
	{!! Form::label('Content','Content: ') 	!!}
	{!! Form::textarea('Content', $aThread[0]->Content , ['class' => 'form-control'])!!}
	{!! Form::submit('Submit',['class' => 'btn btn-primary'])!!}
</div>	

{!! Form::close() !!}

@stop;