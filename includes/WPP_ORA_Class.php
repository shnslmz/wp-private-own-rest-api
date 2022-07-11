<?php
// Prevent direct accessing:
defined( 'ABSPATH' ) or die( 'Exit: Not authorized!' );

class WPP_ORA_Class
{
	/* 
	 * Define vars: plugin settings & apiFirstContent for virtual page
	 */
	public  $WPP_settings;
	public  $WPP_front;	
	
	
	// Constructor
	public function __construct() 
	{	
		$this->init();
	}
	
	
	// Initialize the plugin
	private function init()
	{
		define('WPP_ORA_DB_SET_NAME',   		'wpp_ora_plugin_settings');
		define("WPP_ORA_ROOT_URL", 				plugin_dir_url( dirname(__FILE__ , 1) ));
		define('WPP_ORA_VERSION', 				'1.0.0');
		
		$this->WPP_load();
	}
	
	
	
	// Set actions etc. 
	public function WPP_load()
	{	
		// Add plugin to the menu
		add_action('admin_menu', 				array($this, 'WPP_add_plugin_to_menu') );
		
		// Set wp_options
		add_action( 'init', 					array($this, 'WPP_get_settings_vals')	);
		
		//make custom slug for frontend page
		add_action( 'wp_loaded', 				array($this, 'wpp_slug_init_external')	);
		
		add_shortcode('WPP_show_data2front_opt',array($this, 'WPP_ora_set_shortcode') );
	}
	
	
	
	
	/*
	 * Set plugin's vars to wp_options table
	 */
	public function WPP_set_DB_options()
	{
		$guID	  			= time();
		$optionValues 		= array('guid' 		 => $guID,
									'api_url'	 => 'https://jsonplaceholder.typicode.com/users',
									'ed_access'	 => 1,
									'slug'		 => 'wpp-virtual-page',
									'updated_at' => date('Y-m-d H:i:s')
								);
		
		// Save option & set it to global var.
		add_option(WPP_ORA_DB_SET_NAME,  $value = $optionValues, $deprecated = '', $autoload = 'yes');
		$this->WPP_settings = $optionValues;
	}
	
	
	
	
	
	/*
	 * Get plugin saved data settings val.
	 */
	public function WPP_get_settings_vals()
	{
		if(!isset($this->WPP_settings) || !$this->WPP_settings['guid'])
		{
			$settings = get_option(WPP_ORA_DB_SET_NAME);
			return $this->WPP_settings = $settings;
		}
	}


	
	
	
	/* 
	 * Set a short code for the plugin and 
	 * Show the table with API datas on front-end default page
	 */ 		 
	public function WPP_ora_set_shortcode() 
	{	
		#die(var_dump($this->WPP_settings));
		
		// Call, set a var. to use it again in includes/template to show data: 
		require_once('WPP_ORA_front_side.php'); 
		
		$this->WPP_front = WPP_ORA_get_datas_from_api($this->WPP_settings['api_url']);
		return $this->WPP_front;
	}
	
	
	
	
	
	/*
	 * Create a default page
	 */
	 
	public function WPP_ora_activation_set()
	{
		include_once('WPP_db_file.php');
		$guid = $this->WPP_settings['guid'];
		
		// Create default page
		if($guid && $guid > 0)
			WPP_create_post_forFront($guid);
	}

	
	
	
	/*
	 * Virtual page function
	 */
	function wpp_slug_init_external()
	{
		$this->WPP_ora_set_shortcode();
		
		// Get request uri slug
		$current_rel_uri = add_query_arg(NULL, NULL);  // $_SERVER['REQUEST_URI']
		
		// Check wpp settings slug for frontpage
		$slug = $this->WPP_settings['slug'];
		
		if ($current_rel_uri == "/".$slug)
		{
			include('WPP_template.php');
			exit;
		}
	}
	
	
	
	
	
	/*
	 * Add plugin to end of the menu
	 */ 
	public function WPP_add_plugin_to_menu() 
	{
		$manage_option	   = 'edit_pages';
		if($this->WPP_settings['ed_access'] === 0)
			$manage_option = 'manage_options';
		
		add_menu_page('WP Private Own REST API Plugin', 			// page title
						'Private REST API', 						// menu title
						$manage_option,								// capability--permis. | manage_options||edit_pages
						'wp-private-rest-api', 						// slug
						array($this, 'WPP_render_admin_page'), 		// callable
						'',											// icon_url
						NULL  );	
	}
	
	 
	
	
	
	/* 
	 * Show the main page for the plugin admin settings
	 */ 
	public function WPP_render_admin_page() 
	{		
		// Show settings form with its data
		include_once('WPP_settings.php');
		WPP_ora_settings_form($this->WPP_settings);
		
		// If update request is exist.
		$update_plugin_set = WPP_update_data($this->WPP_settings);
		if($update_plugin_set)
			echo '<hr /><h3 class="wpp-successfull">Update successfull</h3>';
	}
	
	 
	 
	 
	// Set actions for styles & scripts
	public function WPP_enqueue_scripts()
	{	
		// Style and JS & CSS for admin
		add_action('admin_enqueue_scripts', array($this, 'WPP_reqister_scripts_admin') ); 
		
		// Style and JS & CSS for front-end side // init
		add_action('wp_enqueue_scripts', 	array($this, 'WWP_reqister_enqueue_scripts_front') );
	}
	
	 
	
	
	/*
	 * Add assets (CSS and JS) files For admin
	 */
	public function WPP_reqister_scripts_admin()
	{	
		wp_enqueue_style('main_style', 	 	WPP_ORA_ROOT_URL.'admin/css/main.css');
		wp_enqueue_script('main_script', 	WPP_ORA_ROOT_URL.'admin/js/main.js'  );
	}
	
	
	 
	 
	/*
	 * Add assets (CSS and JS) files For front-end side
	 */
	public function WWP_reqister_enqueue_scripts_front()
	{
		// Jquery
		wp_enqueue_script('wpp_jquery', 	 		WPP_ORA_ROOT_URL.'public/js/jquery.min.js' );
		
		// Bootstrap
		wp_enqueue_style('wpp_bootstrap_style', 	WPP_ORA_ROOT_URL.'public/css/bootstrap.min.css');
		wp_enqueue_script('wpp_bootstrap_script', 	WPP_ORA_ROOT_URL.'public/js/bootstrap.min.js');
		
		// DataTable JS & CSS
		wp_enqueue_script('wpp_datatable_script', 	WPP_ORA_ROOT_URL.'public/js/jquery.dataTables.min.js');
		wp_enqueue_style('wpp_datatable_style', 	WPP_ORA_ROOT_URL.'public/css/jquery.dataTables.min.css');
		
		// Main JS & CSS 
		wp_enqueue_style('wpp_main_style', 	 		WPP_ORA_ROOT_URL.'public/css/main.css');
		wp_enqueue_script('wpp_main_script', 		WPP_ORA_ROOT_URL.'public/js/main.js');	
		
		// set api url var to use for api url
		wp_add_inline_script('wpp_main_script',  	'var api_url_opt = "'.$this->WPP_settings['api_url'].'"' );
	}
	
	


	// delete default page if the plugin is deactivated
	public function WPP_deactive_plugin()
	{
		// delete option for site and multi-side
		delete_option(WPP_ORA_DB_SET_NAME);
		delete_site_option(WPP_ORA_DB_SET_NAME);
		
		// delete default plugin page
		global $wpdb;
		$guid = $this->WPP_settings['guid'];
		$wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE post_name = 'wpp-ora-plugin' ");
		//$wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE guid = '{$wpdb->prefix}' "); 
	}
	
	
}
// End of class