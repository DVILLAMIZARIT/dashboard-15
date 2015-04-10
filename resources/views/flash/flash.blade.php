@section('flash')

<div class="container">
	@if (Session::has('flash_message'))
	<div class="alert alert-success">{{session::get('flash_message')}}</div>
	@endif
</div>

<script>
	$('div.alert').delay(2000).slideUp(300);
</script>
@stop