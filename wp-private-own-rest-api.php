<?php
/*
 * Plugin Name:  	  Private Own REST API
 * Plugin URI:   	  https://wp.currentsatellitetime.co
 * Description:  	  This plugin shows X API's datas for its users as a datatable on front-end side.
 * Version: 	 	  1.0.0
 * Requires: 		  +5.2
 * Requires PHP:      +7.2
 * Author: 		 	  Sahin SOLMAZ
 * Author URI:   	  https://sahinsolmaz.com
 * Update URI:		  wp-private-own-rest-api-opt
 * License: 	 	  GPL2
 */


// Prevent direct accessing:
defined( 'ABSPATH' ) or die( 'Exit: Not authorized!' );


// include & run class
include_once('includes/WPP_ORA_Class.php');

if (class_exists('WPP_ORA_Class')) 
{
	$plugin = new WPP_ORA_Class();

	// do installation things
	register_activation_hook( __FILE__, 	array($plugin, 'WPP_set_DB_options' )	);
	register_activation_hook( __FILE__, 	array($plugin, 'WPP_ora_activation_set') );

	$plugin->WPP_enqueue_scripts();

	register_deactivation_hook( __FILE__,   array($plugin, 'WPP_deactive_plugin') );	
}