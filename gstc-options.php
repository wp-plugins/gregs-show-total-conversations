<?php

/*  Greg's Options Page Setup

	Copyright (c) 2009-2015 Greg Mulhauser
	http://gregsplugins.com

	Released under the GPL license
	http://www.opensource.org/licenses/gpl-license.php

	**********************************************************************
	This program is distributed in the hope that it will be useful, but
	WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	*****************************************************************
*/

if ( !function_exists( 'is_admin' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

require_once 'gstc-options-functions.php';

function gstc_options_setngo( $option_style = 'consolidate' ) {
	$name = "Greg's Show Total Conversations";
	$plugin_prefix = 'gstc';
	$domain = $plugin_prefix . '-plugin'; // text domain
	$instname = 'instructions'; // name of page holding instructions
	$plugin_page = " <a href=\"http://gregsplugins.com/lib/plugin-details/gregs-show-total-conversations/\">Greg's Show Total Conversations plugin</a>";
	$paypal_button = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" name="paypalsubmit" alt="" border="0" /></a>';
	$notices = array();
	// WP 3.0 apparently fails occasionally to allow plugins newly activated on a subdomain to add options, so if we have no options, this will let us know; note that the workaround assumes consolidated options style
	if ( false === get_option( "{$plugin_prefix}_settings" ) )
		$notices[] = array(
			'error',
			__( "On rare occasions when using WordPress 3.0+ in multisite/network mode, WordPress interferes with the normal process by which plugins first save their settings with default values. This plugin has detected that its default settings have not yet been saved, and it will not operate correctly with empty settings. Please deactivate the plugin from your plugin management screen, and then reactivate it. Hopefully WordPress will then allow the plugin to initialise its required settings.", $domain ),
		);
	$replacements = array(
		'%plugin_page%' => $plugin_page,
		'%paypal_button%' => $paypal_button,
		'%nbsp%' => '&amp;nbsp;',
	);
	$problems = array();
	$pages = array (
		'default' => array(
			"$name: " . __( 'Configuration', $domain ),
			__( 'Configuration', $domain ),
		),
		$instname => array(
			"$name: " . __( 'Instructions and Setup', $domain ),
			__( 'Instructions', $domain ),
		),
		'donating' => array(
			"$name: " . __( 'Supporting This Plugin', $domain ),
			__( 'Contribute', $domain ),
		),
	);

	$args = compact( 'plugin_prefix', 'instname', 'replacements', 'pages', 'notices', 'problems', 'option_style' );

	$options_handler = new gstcOptionsHandler( $args ); // prepares settings
	$options_handler->display_options( $name );

	return;
} // end displaying the options

if ( current_user_can( 'manage_options' ) ) gstc_options_setngo();

?>
