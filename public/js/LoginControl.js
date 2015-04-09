function LoginControl()
{
	
	if (window.confirm('You are not logged, do you wish to login ?'))
	{
		alert("ok");
		$.ajax({
		type    :"POST",
    	url     :"Dashboard",
		error: function(e){
                alert( 'Error ' + e );
                }
		}
    
		);
	}		
	else
	{
		$.ajax({
		type    :"POST",
    	dataType:"json",
		url     :"http://localhost/laravel/public/form-data",
		success :function(response) {
				alert("thank u");
		}
		});
}		
}