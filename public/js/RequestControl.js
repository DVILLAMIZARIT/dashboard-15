
// constructor of RequestHandler
function RequestHandler()
{
		// the data from the request
		this.data;
		// the current total number of pages
		this.totalNbPages=0;
		// the initial total number of pages that we do not want to forget
		this.initTotalNbPages=0;
		// we add a click event listener for button only
		this.nbLinesPerPage=parseInt(document.getElementById ('nbLinesPerPage').value);
		// the currentPage we are displaying
		this.currentPage=1;
		// event listener
		
}

RequestHandler.prototype.setData= function(nData)
{
	this.data=nData;
};

RequestHandler.prototype.setTotalNbPages= function(nbpages)
{
	this.totalNbPages=nbpages;
};

RequestHandler.prototype.setNbLinesPerPage= function (nblines)
{
	this.nbLinesPerPage=nblines;
};

RequestHandler.prototype.updateIndicators= function ()
	{//this.totalNbPages = Math.round(this.data.length/this.nbLinesPerPage);
		
		// update the total number of pages available
		this.nbLinesPerPage = parseInt(document.getElementById ('nbLinesPerPage').value);
		document.getElementById('totalNbPages').innerHTML=this.totalNbPages;
		document.getElementById('currentPage').value=this.currentPage;	
	}
	
	// This function check if any of our manipulation send us to the wrong page or not 
RequestHandler.prototype.checkPageIntegrity =function ()
	{

		this.updateIndicators();
		// we do not want to see the fourth page if we only have three
	
		// if we input negative value
		if(parseInt(document.getElementById('currentPage').value)<=0)
		{
			this.currentPage=1;
		}
		
		// if we input too high value
		if(parseInt(document.getElementById('currentPage').value)<=parseInt(this.totalNbPages))
		{
			this.currentPage=document.getElementById('currentPage').value;
		}else
		{
			this.currentPage=1;
		}
		
	
		//var firstline = (parseInt(this.currentPage)-parseInt(1))*parseInt(this.nbLinesPerPage);
		
		// if by any action made by the user the current page is not legal to be displayed
		// we go back to the first page
		//if(this.data.length<=firstline)
		//{
		//	this.currentPage=1;	
		//}//
		
	}
	
	// this function will handle every display request from the interface 
RequestHandler.prototype.displayRequest=function (buttonid)
	{	
		switch(buttonid)
		{
			case "search":
				// Initial request
				this.sendrequest(this,"search");
			break;
			
			case "next":
				// if we did not reach the last page already
				if(this.currentPage<this.totalNbPages)
				{
					this.currentPage=parseInt(this.currentPage)+1;
					this.sendrequest(this,"next");
				}
			break;
						
			case "prev":
				// if we did not reach the first page already
				if(this.currentPage>1)
				{
					this.currentPage=parseInt(this.currentPage)-1;
					this.sendrequest(this,"prev");
				}
			break;
			
			case "nbLinesPerPage":
				this.nbLinesPerPage=parseInt(document.getElementById ('nbLinesPerPage').value);
				this.totalNbPages=Math.round(this.initTotalNbPages/(parseInt(this.nbLinesPerPage)/parseInt(10)));
				//this.totalNbPages = Math.round(this.totalNbPages/this.nbLinesPerPage);
				//if  initial request has been made
				if(this.initTotalNbPages!=0)
				{	
					this.sendrequest(this,"nbLinesPerPage");
				}
			break;
			
			case "currentPage":
				if(this.initTotalNbPages!=0)
				{
					this.currentPage=document.getElementById('currentPage').value;
					// in order to check what input the user
					this.checkPageIntegrity();
					this.sendrequest(this,"currentPage");
				}
			break;
			
		}
	}
	
	
	// recover data from form, send a request to laravel
	// once in the ajax object, this' context change
	// if we want to still have access to the class while beeing in the ajax object
	// we can send an instance of the RequestHandler ( here Handler)
RequestHandler.prototype.sendrequest= function (Handler,buttonid)
	{
		var mquery = document.getElementById('query').value;
		var mlimit = parseInt(Handler.nbLinesPerPage);
		//document.getElementById('limit').value;
		
		// we determine the offset according to the page we are currently looking
		var offset =(parseInt(Handler.currentPage)-1) * parseInt(Handler.nbLinesPerPage);
		//if(buttonid!="search")
		//{
		//	mlimit= 
		//}
		var obj= {'query':mquery,'limit':mlimit,'offset':offset}
				
		$.ajax({
		type    :"GET",
		data :(obj),
		url     :"messages",
		dataType:"json",
		error: function(e){
				   alert( 'Error ' + e );
				},
		success :function(response) {
					Handler.data=response;
					 // we initialize the number of pages according the data returned by laravel
					console.log(response);
					$(document).ready(Handler.senddata());
					// ajax is asynchronous, we must 
					
					if(buttonid=="search")
					{
						Handler.initTotalNbPages = Math.round(Handler.data[Handler.data.length-1]['Title']/Handler.nbLinesPerPage);
						Handler.totalNbPages=Handler.initTotalNbPages;
					}
					$(document).ready(Handler.checkPageIntegrity());
					//$(document).ready(Handler.updateIndicators());
					
				return false;
			}
		})
	}
	
	// this function send the appropriate information to the form 
	// page = the current page you want to display
	RequestHandler.prototype.senddata=function ()
	{
	 var table =document.getElementById('resultats');
	 var limit=0;
	 var response ="<tr ='result odd selected' >";
	 var lastline = parseInt(this.nbLinesPerPage)*parseInt(this.currentPage);
		
		// if we do not have enough lines to make a complete page
		if(this.nbLinesPerPage>this.data.length)
		{	limit=this.data.length-1; }
		else // we know that we have more lines than the page is supposed to contain
		{	limit=this.nbLinesPerPage;}
	
		console.log(this.data.length);
		//var firstline = (parseInt(this.currentPage)-parseInt(1))*parseInt(this.nbLinesPerPage);
		for(var i=0;i<limit-1;i++)
		{	
			
			response+="<tr class='result even'><td>"+this.data[i]['id']+"</td>";
			response+="<td>"+this.data[i]['Title']+"</td>";
			response+="<td>"+this.data[i]['Pending']+"</td></tr>";
			
			// in order to alternate background color
			if(i<limit-1)
			{
				i++;
				response+="<tr class='result odd'><td>"+this.data[i]['id']+"</td>";
				response+="<td>"+this.data[i]['Title']+"</td>";
				response+="<td>"+this.data[i]['Pending']+"</td></tr>";
			}
		}
		response +="</tr>";
		table.innerHTML=response;
		
		return false;
		//document.write(response);
	}
