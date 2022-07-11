<?php
// Prevent direct accessing:
defined( 'ABSPATH' ) or die( 'Exit: Not authorized!' );

/*
 * Create a private post page to show plugin's output (using shortcode).
 */
function WPP_create_post_forFront($guid)
{
	global $wpdb;
	 
	// Check default page is created? Using $guid (as a static reference).
	$post_name 		= 'wpp-ora-plugin';
	$checkPostName 	= $wpdb->get_row( "SELECT guid FROM {$wpdb->prefix}posts WHERE guid = '$guid'", 'ARRAY_A' );
	
	
	// If the default page was not created before create it
	if(NULL ===  $checkPostName)
	{
		if(!function_exists('wp_get_current_user')) {
			include(ABSPATH . "wp-includes/pluggable.php"); 
		}
		
		// Get current user's ID 
		$current_user    = wp_get_current_user()->ID;
		
		// Insert default page
		$insertPageID 	 = $wpdb->insert($wpdb->prefix.'posts', 
							array(	'guid'				=> $guid,
									'post_title'  		=> 'WP Private Own REST API OPT',
									'post_status' 		=> 'publish',
									'post_author' 		=> $current_user,
									'post_type'   		=> 'page',
									'post_name'   		=> $post_name,
									'comment_status'	=> 'closed',
									'post_content'		=> '<!-- wp:shortcode -->
																[WPP_show_data2front_opt][/WPP_show_data2front_opt]
															<!-- /wp:shortcode -->'				
								) 
							);
		if(!$insertPageID){
			echo 'Sth. went wrong when inserting the default page for plugin. The error: <br />';
			echo $wpdb->last_error;
			die();
		}
		else
			return true;
	}
	
}
// End of default page creating function