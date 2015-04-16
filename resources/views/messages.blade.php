@extends('admintemplate')
@section('content')
<div id=wrapper>
<header>
<h1><a href="Dashboard">Dashboard</a></h1>
</header>
</div>

<div id="admin_page" class="with_sidebar" style="min-height: 505px;">
	<div id="sidebar">
	<div class="panel sidebar_section" id="filters_sidebar_section">
	<h2>Filters</h2>
<div class="filters">
	<div class="key ">
		<label >id:</label>
		<input type="text">
	</div>
	<div class="text ">
		<label >Title:</label>
		<input type="text">
	</div>
	<div class="text ">
		<label >Pending:</label>
		<input type="text">
	</div>
</div>
</div>
	</div>
	<div id="content">
	<div class="table_container" style="margin-right: 290px;">
	<div class="results_header">
		<h2>Dashboard</h2>
	</div>

	<div class="page_container">
		<div class="per_page">
			<select id="nbLinesPerPage">
			<option >10</option>
			<option >20</option>
			<option >30</option>
			<option >40</option>
			<option >50</option>
			</select>
			
		<span> items per page</span>
		</div>
		<div class="paginator">
			<input type="button" id="prev" value="prev">
			<input type="button" id="next" value="next">
			<input type="text" value=1 id="currentPage">
			<label id="totalNbPages">1</label>
		</div>
	</div>

	<table class="results" border="0" cellspacing="0" id="customers" cellpadding="0">
		<thead>
			<tr>
				<th><div>id</div></th>
				<th><div>Title</div></th>
				<th><div>Pending</div></th>
			</tr>
		</thead>

		<tbody id="resultats">
			
		</tbody>
	</table>
</div>

<div class="item_edit_container">
<div class="item_edit" , style: {width: (expandWidth() - 27) + 'px'}" style="margin-left: 2px; width: 258px;">
<form class="edit_form">
	<h2>Search</h2>
		
		<div class="text" >
		<label>Title:</label>
		<input type="text" id="query">
		</div>
				
	<div class="control_buttons">
		<input type="button" value="Search" id="search" >
	</div>
	

</form>
<script type="text/javascript">
// instantiate the class
var Handler = new RequestHandler();

// generate the listeners

		$(':text').change(function() {
			// if an event is already triggered
			if ($(this).data("executing")) return;
			// we prevent the execution of several request while the first one is not finished
			$(this).data("executing", true)
			// the Handler process the request
			Handler.displayRequest($(this).attr('id'));
			// another request can now be processed
			$(this).removeData("executing");			
		});
	
		$(':button').click(function() {
			if ($(this).data("executing")) return;
			$(this).data("executing", true)
			Handler.displayRequest($(this).attr('id')); 
			$(this).removeData("executing")			
		});
	
		
		$('select').change(function() {
			if ($(this).data("executing")) return;
			$(this).data("executing", true)
			Handler.displayRequest($(this).attr('id')); 
			$(this).removeData("executing")			
		});
</script>
</div></div>
</div>

@stop

