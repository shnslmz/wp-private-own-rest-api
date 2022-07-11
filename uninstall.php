<?php

// prevent direct access
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$option_name = 'wpp-virtual-page-opt';

/*
 * Delete option was cancelled here					*
 * because we use them after plugin deactivation	*
 
 # delete option
   delete_option($option_name);
 
 # for site options in Multisite
   delete_site_option($option_name);
   
 *
 */