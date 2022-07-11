<?php
// Prevent direct accessing:
defined( 'ABSPATH' ) or die( 'Exit: Not authorized!' );

/*
 * Get data from API URL 
 * Parse it and,
 * Show on a HTML table
 */
function WPP_ORA_get_datas_from_api($url)
{
	// Set table format:
	$htmlOutput		= '<h2 class="centerTxt">WP P.O.R.A Page</h2>
					   <table id="WPP_ora_dt" class="display" style="width:100%">
						<thead>
							<tr>
								<th id="WPP_sort_ID">#ID</th>
								<th id="WPP_sort_name">Name</th>
								<th id="WPP_sort_username">Username</th>
								<th id="WPP_sort_email">E-mail</th>
							</tr>
						</thead>
						';
	
	// Set args.
	$arguments 		= array('method' => 'GET');
	
	// Get response
	$getResponse 	= wp_remote_get($url, $arguments);
	
	// Check it has any errors?
	if(is_wp_error($getResponse))
	{	
		$error = $getResponse->get_error_message();
		echo '<h2 >Sth. went wrong: '.$error. '<br /> The uri: </h2>'.$url;
		
	}
	else
	{
		$bodyContent	= wp_remote_retrieve_body($getResponse);
		$result			= json_decode($bodyContent);
		
		foreach($result as $key => $value)
		{ 
			$htmlOutput.= "<tr onclick='getDetails(".($value->id).");'>
								<td>".esc_html($value->id)."</td>
								<td>".esc_html($value->name)."</td>
								<td>".esc_html($value->username)."</td>
								<td>".esc_html($value->email)."</td>
							</tr>";
		}
		
		// to show modal
		$HTMLmodal 		= '<div class="container"> <!-- Modal --> <div class="modal fade" id="myModal" role="dialog"><div class="modal-dialog" style="margin-top:5%;"> <!-- Modal content--> <div class="modal-content"><div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> <h4 class="modal-title" >Results:</h4></div><div class="modal-body" id="apiReulstDv"> <p>Test</p></div><div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div> </div></div> </div></div>';
		$htmlOutput		.= '</table>'.$HTMLmodal;
		
		return $htmlOutput; 
	}
	
}
// End of get data from api function