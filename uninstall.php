<?php
if( !defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
} else {
	   if (current_user_can('delete_plugins')) {
		   $gstc_settings = array ('gstc_auto_admin', 'gstc_auto_post', 'gstc_auto_index', 'gstc_auto_archive', 'gstc_style_override', 'gstc_zero', 'gstc_one', 'gstc_more', 'gstc_thank_you', 'gstc_thank_you_message');
		   // Nuke the options
		   echo '<div id="message" class="updated fade">';
		   foreach($gstc_settings as $setting) {
			   $delete_setting = delete_option($setting);
			   if($delete_setting) {
				   echo '<p style="color:green">';
				   printf(__('Setting \'%s\' has been deleted.', 'gstc-plugin'), "<strong><em>{$setting}</em></strong>");
				   echo '</p>';
			   } else {
				   echo '<p style="color:red">';
				   printf(__('Error deleting setting \'%s\'.', 'gstc-plugin'), "<strong><em>{$setting}</em></strong>");
				   echo '</p>';
			   }
		   }
		   echo '<strong>Thank you for using Greg&#8217;s Show Discussions Number plugin!</strong>';
		   echo '</div>'; 
	  }
}

?>
