<?php

require_once('gstc-options-functions.php');

function gstc_options_setngo() {
$name = "Greg's Show Total Conversations";
$settings_prefix = 'gstc_options_'; // prefix for each distinct set of options registered, used by WP's settings_fields to set up the form correctly
$domain = 'gstc-plugin'; // text domain
$plugin_prefix = 'gstc_'; // prefix for each option name, with underscore
$subdir = 'options-set'; // subdirectory where options ini files are stored
$instname = 'instructions'; // name of page holding instructions
$dofull = get_option('gstc_abbreviate_options') ? false : true; // set this way so unitialized option default of zero will equate to "do not abbreviate, show us full options"
$donated = get_option('gstc_donated');
$site_link = ' <a href="http://counsellingresource.com/">CounsellingResource.com</a>';
$plugin_page = " <a href=\"http://counsellingresource.com/features/2009/02/16/show-total-conversations/\">Greg's Show Total Conversations plugin</a>";
$paypal_button = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" name="paypalsubmit" alt="" border="0" /></a>';
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

$options_handler = new gstcOptionsHandler($replacements,$pages,$domain,$plugin_prefix,$subdir,$instname); // prepares settings
$options_handler->display_options($settings_prefix,$problems,$name,$dofull,$donated);

return;
} // end displaying the options

if (current_user_can('manage_options')) gstc_options_setngo();

?>