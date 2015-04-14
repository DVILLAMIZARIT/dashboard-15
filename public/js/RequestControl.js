
var RequestHandler
{
	// the data from the request
	var data;
	// the current total number of pages
	var totalNbPages;
	// we add a click event listener for button only
	var nbLinesPerPage;
	// the currentPage we are displaying
	var currentPage;
	// event listener for button
	
	function setData(nData)
	{
		data=nData;
	};
	
	function setTotalNbPages(nbpages)
	{
		totalNbPages=nbpages;
	};

	function setNbLinesPerPage(nblines)
	{
		nbLinesPerPage=nblines;
	};
	
	// init the variables	
	function init()
	{
		nbLinesPerPage = parseInt(document.getElementById ('nbLinesPerPage').value);
		// at the init we force the page to be the first one
		currentPage = 1;
		
		$(':text').change(function() {
		displayRequest($(this).attr('id'));    
		});
	
		$(':button').click(function() {
			displayRequest($(this).attr('id'));    
		});
	
		// event listener for select
		$('select').change(function() {
			displayRequest($(this).attr('id'));   	
		});
	}
	
	// function is to indicators values of the form
	function updateIndicators()
	{
		// update the total number of pages available
		nbLinesPerPage = parseInt(document.getElementById ('nbLinesPerPage').value);
		totalNbPages = Math.round(data.length/nbLinesPerPage);
		document.getElementById('totalNbPages').innerHTML=totalNbPages;
		document.getElementById('currentPage').value=currentPage;	
	}
	
	// This function check if any of our manipulation send us to the wrong page or not 
	function checkPageIntegrity()
	{
	
		// we do not want to see the fourth page if we only have three
	
		//alert(parseInt(document.getElementById('currentPage').value));
		
		// if we input negative value
		if(parseInt(document.getElementById('currentPage').value)<=0)
		{
			currentPage=1;
		}
		
		// if we input too high value
		if(parseInt(document.getElementById('currentPage').value)<=parseInt(totalNbPages))
		{
			currentPage=document.getElementById('currentPage').value;
		}
		
		var firstline = (parseInt(currentPage)-parseInt(1))*parseInt(nbLinesPerPage);
		
		// if by any action made by the user the current page is not illegible to be displayed
		// we go back to the first page
		if(data.length<=firstline)
		{
			currentPage=1;	
		}
		
		updateIndicators();
	}
	
	// this function will handle every display request from the interface 
	function displayRequest(buttonid)
	{
		switch(buttonid)
		{
			case "next":
				// if we did not reach the last page already
				if(currentPage<totalNbPages)
				{
					//alert("test");
					currentPage=parseInt(currentPage)+1;
					senddata(); 
					updateIndicators();
				}
			break;
						
			case "prev":
				// if we did not reach the first page already
				if(currentPage>1)
				{
					currentPage=parseInt(currentPage)-1;
					senddata();
					updateIndicators();
				}
			break;
			
			case "nbLinesPerPage":
				updateIndicators();
				checkPageIntegrity();
				senddata();
			break;
			
			case "currentPage":
				checkPageIntegrity();
				senddata();
			break;
			
		}
	}
	
	
	// recover data from form, send a request to laravel
	function sendrequest()
	{
		init();
		var mquery = document.getElementById('query').value;
		var mlimit = document.getElementById ('limit').value;
		
		var obj= {'query':mquery,'limit':mlimit,'offset':1}
		
		$.ajax({
		type    :"GET",
		data :(obj),
		url     :"messages",
		dataType:"json",
		error: function(e){
				   //alert( 'Error ' + e );
				},
		success :function(response) {
					data=response;
					 // we initialize the number of pages according the data returned by laravel
					updateIndicators();
					document.getElementById('totalNbPages').innerHTML=totalNbPages;
					$(document).ready(senddata(1));
					return false;
			}
		})
	}


	
	// this function send the appropriate information to the form 
	// page = the current page you want to display
	function senddata()
	{
	 var table =document.getElementById('resultats');
	 var limit=0;
	 var response ="<tr ='result odd selected' >";
	 
		var lastline = parseInt(nbLinesPerPage)*parseInt(currentPage);
		// if we do not have enough lines to make a complete page
		if(lastline>data.length)
		{	limit=data.length; }
		else // we know that we have more lines than the page is supposed to contain
		{	limit=lastline;}
		
		// we start with the first line of the requested page
		var firstline = (parseInt(currentPage)-parseInt(1))*parseInt(nbLinesPerPage);
	
		for(var i=firstline;i<limit-1;i++)
		{	
			response+="<tr class='result even'><td>"+data[i]['id']+"</td>";
			response+="<td>"+data[i]['Title']+"</td>";
			response+="<td>"+data[i]['Pending']+"</td></tr>";
			
			// in order to alternate background color
			i++;
			
			response+="<tr class='result odd'><td>"+data[i]['id']+"</td>";
			response+="<td>"+data[i]['Title']+"</td>";
			response+="<td>"+data[i]['Pending']+"</td></tr>";
		}
		response +="</tr>";
		table.innerHTML=response;
		return false;
		//document.write(response);
	}

}
