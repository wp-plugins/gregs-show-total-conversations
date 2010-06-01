<?php

/*  Greg's Options Page Setup
	
	Copyright (c) 2009-2010 Greg Mulhauser
	http://counsellingresource.com
	
	Released under the GPL license
	http://www.opensource.org/licenses/gpl-license.php
	
	**********************************************************************
	This program is distributed in the hope that it will be useful, but
	WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
	*****************************************************************
*/

if (!function_exists ('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
	}

require_once('gstc-options-functions.php');

function gstc_options_setngo($option_style = 'consolidate') {
	$name = "Greg's Show Total Conversations";
	$plugin_prefix = 'gstc';
	$domain = $plugin_prefix . '-plugin'; // text domain
	$instname = 'instructions'; // name of page holding instructions
	$site_link = ' <a href="http://counsellingresource.com/">CounsellingResource.com</a>';
	$plugin_page = " <a href=\"http://counsellingresource.com/features/2009/02/16/show-total-conversations/\">Greg's Show Total Conversations plugin</a>";
	$paypal_button = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" name="paypalsubmit" alt="" border="0" /></a>';
	$notices = array();
	$replacements = array(
						 '%site_link%' => $site_link,
						 '%plugin_page%' => $plugin_page,
						 '%paypal_button%' => $paypal_button,
						 '%nbsp%' => '&amp;nbsp;',
						 );
	$problems = array();
	$pages = array (
				   'default' => array(
				   "$name: " . __('Configuration',$domain),
				   __('Configuration',$domain),
				   ),
				   $instname => array(
				   "$name: " . __('Instructions and Setup',$domain),
				   __('Instructions',$domain),
				   ),
				   'donating' => array(
				   "$name: " . __('Supporting This Plugin',$domain),
				   __('Contribute',$domain),
				   ),
				   );
	
	$args = compact('plugin_prefix','instname','replacements','pages','notices','problems','option_style');
	
	$options_handler = new gstcOptionsHandler($args); // prepares settings
	$options_handler->display_options($name);
	
	return;
} // end displaying the options

if (current_user_can('manage_options')) gstc_options_setngo();

?>