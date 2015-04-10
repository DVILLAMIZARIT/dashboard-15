@include('flash.flash')

<head>
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ URL::asset('js/LoginControl.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.1.3.js') }}"></script>
<head>

<header>
<nav class="navbar navbar-default">
<div class="container-fluid">
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav" id="test">
	<li>
    <a href="\Dashboard">Home</a>
    </li>
    <li>
    <a href="\admin">Administration page</a>
    </li>
</ul>
<ul class="nav navbar-nav navbar-right" id="test">
    <li>
	@if (\Auth::guest())
    <a href="/auth/login">login</a>
	</li>
	<li>
	<a href="/auth/register">Register</a>
	</li>
	@else
	<a href="/auth/logout">logout</a>
	@endif
</ul>	
</nav>
</div>
</div>
</header>

<body>

	@yield('flash')
	<div class="col-md-8 col-md-offset-2">
		@yield('content')
	</div>

</body>

<footer>
@if($errors->any())
		<ul class="alert.alert-danger">
		@foreach( $errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
@endif
</footer>