<?php
// Prevent direct accessing:
defined( 'ABSPATH' ) or die( 'Exit: Not authorized!' );

/*
 * It shows settings form for the plugin's admin page 
 */
function WPP_ora_settings_form($settings)
{
	?>	
	<div id='WPP_main'>
		<h1 style='text-align:center;'>WP P. own REST API Main Settings Page</h1>
		<hr />
		<br />
		<form method='POST'>
			<div id='parent'>
				<label> Endpoint slug: </label>
				<input type='text' name='slug' value='<?php echo $settings['slug'];?>' 
					   required  autofocus maxlength='100' style="width: 300px;" />
				<i>(it is replaced as a slug. max char. is 100..)</i>
				
				<br /><br />
				<label>Is editor Acess: </label>
				<select name="ed_access" required maxlength='1' style="width: 300px;" >
					<option value="1" <?php if($settings['ed_access']===1) echo 'selected';?> >Yes editors access</option>
					<option value="0" <?php if($settings['ed_access']===0) echo 'selected';?> >No editors can't access</option>
				</select>
				
				<i>(editor can access to plugin settings page by defalt..)</i>
				
				
				<br /><br />
				<label> REST API URL: </label>
				<input type='url' name='api_url' value='<?php echo $settings['api_url'];?>' 
					   required maxlength='120' style="width: 300px;" />
				<i>(it must be a valid uri. max char. is 120..)</i>
				 
				<br /><br /><button>Send</button>
			</div>
		</form>
		<br />
		<hr />
		
		<?php
		 
		echo '<br /><h3>General info:</h3>';
		echo '<ul>
				<li><b>Visit virtual page:</b>';
		echo '		<a target="_blank" href="'.get_home_url().'/'.$settings['slug'].'">
					WP Private Own REST API Page </a>  <i>(this is a virtual page not exist..)</i>
				</li>';
		
		echo '<li><b>Visit front page:</b>
				<a target="_blank" href="'.esc_url( get_permalink( get_page_by_title( "WP Private Own REST API OPT" ) ) ).'">
				WP Private Own REST API Page </a>  <i>(this is auto-generated page..)</i>
			  </li>';
		
		echo '<br /><li><b>Last updated at:</b> '.$settings['updated_at'].'</li>
			  <li><b>The shortcode:</b><pre>[WPP_show_data2front][/WPP_show_data2front]</pre>'.'</li>
			  </ul>';		
}
// End of plugin settings function




/* 
 * Plugin update settings function if the request is exist.
 */ 
function WPP_update_data($settings)
{
	// if update request was not set, exit;
	if(!$_POST)
		return;
	
	global $wpdb;
	$WPP_table_name = $wpdb->prefix.'wpp_ora_settings';
	
	// Check that it has post request and filled inputs:
	if(isset($_POST['api_url']) 	&&   $_POST['api_url'] 	 && 
	   isset($_POST['slug']) 		&&   $_POST['slug'] 	 && 
	   isset($_POST['ed_access']) 	&&  ($_POST['ed_access'] == '1' or $_POST['ed_access'] == '0') )
	{
		   
		// Get and sanitize uri
		$WPP_api_url 		= substr(trim($_POST['api_url']), 0, 120);
		$WPP_api_url 		= sanitize_url($WPP_api_url);
		
		
		// Get,  sanitize and replace the slug 
		$WPP_slug 			= $_POST['slug']; 
		$WPP_slug 			= generateSlug(sanitize_title($WPP_slug), 100); 
		
		
		// is editor can access input
		$ed_access 			= intval($_POST['ed_access']);
		
		
		// Exit if the URL is NOT valid
		if (!filter_var($WPP_api_url, FILTER_VALIDATE_URL)) 
			die('<hr /><b>The given data is not a valid URL.</b>');
		
		
		$guID				= $settings['guid'];
		// Everything is okay, now update the option:
		$optionValues 		= array('guid' 		 => $guID,
									'api_url'	 => $WPP_api_url,
									'ed_access'	 => $ed_access,
									'slug'		 => $WPP_slug,
									'updated_at' => date('Y-m-d H:i:s')
								);
								
		update_option('wpp_ora_plugin_settings',  $value = $optionValues);
		return true;
	}
	else
		echo '<br /><b>The API URL, slug and editor access fields are required as must be valid.</b>';
}
// End of update req. function





function generateSlug($phrase, $maxLength) 
{
    $result = strtolower($phrase);
    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    $result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", "-", $result);
    return $result;
}