@extends('template')
@section('content')
 
{!! Form::model($aThread,['method' => 'PATCH','action' =>['ThreadController@update', $aThread->id]]) !!}
<div class="form-group">
	{!! Form::label('Content','Content: ') 	!!}
	{!! Form::textarea('Content', $aThread->Content , ['class' => 'form-control'])!!}
	{!! Form::submit('Validate Changes',['class' => 'btn btn-primary'])!!}
</div>	

{!! Form::close() !!}

@stop;