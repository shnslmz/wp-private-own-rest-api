/*
 * It gets user post detail when any tr line was clicked
 */ 
function getDetails(id)
{	
	var sendReq2URL = api_url_opt+'/'+id+'/posts';
	console.log('uri: '+sendReq2URL);
	// i.e: https://jsonplaceholder.typicode.com/users/1/posts
	
	$.getJSON(sendReq2URL, {}, function (data, textStatus, jqXHR) 
	{
		var totalCount = data.length;
		console.log('Total count: '+totalCount);
		
		var htmlOutput = '<ul>';
		// sepearate datas
		for (var i = 0; i < totalCount; i++) 
		{
			//console.log(data[i].title); 
			htmlOutput+='<li class=\'fnt16\'>#'+data[i].id+': '+data[i].title+'</li>';
		}
		
		// Write datas to div
		$('#apiReulstDv').html(htmlOutput);
		
		// Open modal and show datas
		$("#myModal").modal();
	})
	.done(function () { console.log('Request done!'); })
	.fail(function (jqxhr,settings,ex) { alert('failed! the uri: '+sendReq2URL+' | '+ ex); });	
}




/* 
 * Set DataTable Option
 */
$(document).ready(function () 
{
	if ( $.fn.dataTable.isDataTable( '#WPP_ora_dt' ) ) 
	{
		table = $('#WPP_ora_dt').DataTable();
	}
	else 
	{
		table = $('#WPP_ora_dt').DataTable( {
			order: [[0, 'asc']],
		} );
	}

    //$('#WPP_ora_dt').DataTable({ order: [[0, 'asc']], });
});
