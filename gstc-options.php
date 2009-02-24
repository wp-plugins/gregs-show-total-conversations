<?php
/*
	 WordPress 2.7 Plugin: Greg's Show Show Total Conversations 1.0.1
	 Copyright (c) 2009 Greg Mulhauser
	 
	 File Written By:
	 - Greg Mulhauser
	 - http://counsellingresource.com
	 - http://mulhauser.net
	 
	 Information:
	 - Greg's Show Total Conversations Options Page
	 - wp-content/plugins/gregs-show-total-conversations/gstc-options.php
*/

$site_link = ' <a href="http://counsellingresource.com/">CounsellingResource.com</a>';
$plugin_page = ' <a href="http://counsellingresource.com/features/2009/02/16/show-total-conversations/">Greg&#8217;s Show Total Conversations plugin</a>';
$gtcn_page = ' <a href="http://counsellingresource.com/features/2009/01/27/threaded-comment-numbering-plugin-for-wordpress/">Greg&#8217;s Threaded Comment Numbering plugin</a>';

?>

<div class="wrap">
<form method="post" action="options.php"> 
<?php settings_fields('gstc_options'); ?>
<?php screen_icon(); ?>
<h2><?php _e('Greg&#8217;s Show Total Conversations Settings and Usage', 'gstc-plugin'); ?></h2>
<p><?php _e('For usage instructions, please see the README file distributed with this plugin, and for more details please see the plugin page at:', 'gstc-plugin'); echo $plugin_page; ?>.</p>
<div style="margin:1.5em;padding:.5em 1em;border:1px solid grey;background-color:white;">
<p><?php _e('This plugin works especially nicely in conjunction with my separate plugin for numbering comments. For more details on how to number each of your comments, even with threading and paging enabled, see that plugin&#8217;s page at:', 'gstc-plugin'); echo $gtcn_page; ?>.</p>
</div>
<h3><?php _e('Inserting the Discussions Number', 'gstc-plugin'); ?></h3>
<p><?php printf(__('Greg&#8217;s Show Total Conversations plugin can automatically insert the number of threaded discussions wherever the %s function appears within your theme or your admin pages.', 'gstc-plugin'), '<code>&lt;?php comments_number(); ?></code>'); ?></p>
<p><?php printf(__('Alternatively, you can place the number manually and specify the text around it by calling the %s function directly.', 'gstc-plugin'), '<code>&lt;?php gstc_show_discussions_number_manually(); ?></code>'); ?></p>
<table class="form-table">
  <tr>
	  <th scope="row" valign="top"><?php _e('Automatically Show Total Conversations?', 'gstc-plugin'); ?></th>
	  <td>
	  <ul>
		  <li><label for="gstc_auto_admin">
<input name="gstc_auto_admin" type="checkbox" id="gstc_auto_admin" value="1" <?php checked('1', get_option('gstc_auto_admin')); ?> />&nbsp;<?php _e('Show on Admin Pages', 'gstc-plugin'); ?></label></li>
		  <li><label for="gstc_auto_post">
<input name="gstc_auto_post" type="checkbox" id="gstc_auto_post" value="1" <?php checked('1', get_option('gstc_auto_post')); ?> />&nbsp;<?php _e('Show on Single Post Pages', 'gstc-plugin'); ?></label></li>
		  <li><label for="gstc_auto_index">
<input name="gstc_auto_index" type="checkbox" id="gstc_auto_index" value="1" <?php checked('1', get_option('gstc_auto_index')); ?> />&nbsp;<?php _e('Show on Home Page/Front Page', 'gstc-plugin'); ?></label></li>
		  <li><label for="gstc_auto_archive">
<input name="gstc_auto_archive" type="checkbox" id="gstc_auto_archive" value="1" <?php checked('1', get_option('gstc_auto_archive')); ?> />&nbsp;<?php _e('Show on Archive Pages (Date Archives, Author Archives, Tag Archives, etc.)', 'gstc-plugin'); ?></label></li>
	  </ul>
	  </td> 
  </tr>
</table>
<h3><?php _e('How the Discussions Number Will Be Shown', 'gstc-plugin'); ?></h3>
<p><?php printf(__('You can specify the text that will accompany the discussions number in exactly the same way as you can with the built-in %s function.', 'gstc-plugin'), '<code>&lt;?php comments_number(); ?></code>'); ?></p>
<p><?php printf(__('If you&#8217;d like a leading space before any of your text &mdash; for example to ensure the discussions number is separated on the left from your normal comments number &mdash; use the code for a non-breaking space, %s (without the quotes), to indicate a space. This will overcome a limitation in the way WordPress versions 2.7 and later handle text option fields.', 'gstc-plugin'), '\'<code>&amp;nbsp;</code>\''); ?></p>
<table class="form-table">
  <tr>
	  <th scope="row" valign="top"><?php _e('Text to Display for Zero Discussions', 'gstc-plugin'); ?></th>
	  <td>
			  <input type="text" size="40" name="gstc_zero" value="<?php echo get_option('gstc_zero'); ?>" /><br /><?php _e('Suggested: blank', 'gstc-plugin'); ?>
	  </td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Text to Display for One Discussion', 'gstc-plugin'); ?></th>
	  <td>
			  <input type="text" size="40" name="gstc_one" value="<?php echo get_option('gstc_one'); ?>" /><br /><?php _e('Suggested:  (Including One Discussion Thread)', 'gstc-plugin'); ?>
	  </td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Text to Display for Multiple Discussions', 'gstc-plugin'); ?></th>
	  <td>
			  <input type="text" size="40" name="gstc_more" value="<?php echo get_option('gstc_more'); ?>" /><br /><?php _e('Suggested:  (Including % Discussion Threads) ', 'gstc-plugin'); ?><br /><em><?php _e('The percentage sign (%) will be replaced with the number of discussions.', 'gstc-plugin'); ?></em>
	  </td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Apply These Text Settings for Manual Function Calls?', 'gstc-plugin'); ?></th>
	  <td>
	  <ul>
		  <li><input type="radio" name="gstc_style_override" value="1"<?php checked('1', get_option('gstc_style_override')); ?> /> <?php _e('Yes - override anything I specify in a manual function call', 'gstc-plugin'); ?></li>
		  <li><input type="radio" name="gstc_style_override" value="0"<?php checked('0', get_option('gstc_style_override')); ?> /> <?php _e('No - pay attention to manual function call parameters', 'gstc-plugin'); ?></li>
	  </ul>
	  </td> 
  </tr>
</table>
<h3><?php _e('Hat Tip?', 'gstc-plugin'); ?></h3>
<p><?php _e('If you&#8217;d like to show your appreciation for the time and effort that goes into providing free software like Greg&#8217;s Show Total Conversations plugin, you can choose to display a small thank you message in the footer. This is NOT ENABLED by default, but you can enable it here:', 'gstc-plugin'); ?></p>
<table class="form-table">
  <tr>
	  <th scope="row" valign="top"><?php _e('Display Thank You Message?', 'gstc-plugin'); ?></th>
	  <td>
		  <ul>
			  <li><input type="radio" name="gstc_thank_you" value="0"<?php checked('0', get_option('gstc_thank_you')); ?> /> <?php _e('No - do not add anything to my footer', 'gstc-plugin'); ?></li>
			  <li><input type="radio" name="gstc_thank_you" value="1"<?php checked('1', get_option('gstc_thank_you')); ?> /> <?php _e('Yes - display a thank you message as specified below', 'gstc-plugin'); ?></li>
		  </ul>
	  </td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Message to Display (only if selected above):', 'gstc-plugin'); ?></th>
	  <td>
			  <input type="text" size="40" name="gstc_thank_you_message" value="<?php echo get_option('gstc_thank_you_message'); ?>" /><br /><?php printf(__('(The text %s will be replaced with the name and link to the plugin.)', 'gstc-plugin'), '<strong>%THIS_PLUGIN%</strong>'); ?>
	  </td> 
  </tr>
  <tr>
	  <th scope="row" valign="top"><?php _e('Would you like to buy me a coffee instead?', 'gstc-plugin'); ?></th>
	  <td>
<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" name="paypalsubmit" alt="" border="0" /></a></p>
	  </td> 
  </tr>
  <tr>
  <th></th>
  <td>
  <p class="submit">
  <input type="submit" name="Submit" class="button" value="<?php _e('Save Changes', 'gstc-plugin'); ?>" /></p>
</td>
</tr>
</table>
</form>
  <h3><?php _e('Usage', 'gstc-plugin'); ?></h3>
<p><?php _e('Please also see the README file distributed with this plugin and the plugin page at: ', 'gtcn-plugin'); echo $plugin_page; ?>.</p>
<ul style="list-style-type:disc;padding-left:1.5em;">
	<li><?php printf(__('Just enable the option above to show the discussions number automatically, and it will be included along with the text displayed by the function  %s.', 'gstc-plugin'), '<code>&lt;?php comments_number(); ?></code>'); ?></li>
	<li><?php _e('Optionally, you can switch off the automatic option and instead show the number manually wherever you would like by calling the following function, preferably wrapped in a conditional that tests whether the function exists:', 'gstc-plugin'); echo ' <code>&lt;?php gstc_show_discussions_number_manually(); ?></code>'; ?></li>
</ul>
			
<h3><?php _e('Supporting Plugin Development', 'gstc-plugin'); ?></h3>
<p><?php _e('If you find this plugin useful, please consider telling your friends with a quick post about it and/or a mention of our site:', 'gstc-plugin'); echo $site_link; ?>.</p>
<p><?php _e('And of course, donations of any amount via PayPal won&#8217;t be refused! Please see the plugin page for details:', 'gstc-plugin'); echo $plugin_page; ?>.</p>
<p><em><?php _e('Thank you!', 'gstc-plugin'); ?></em></p>
<h3><?php _e('Fine Print', 'gstc-plugin'); ?></h3>
<p style="font-size:.8em"><em><?php _e('This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License version 3 as published by the Free Software Foundation.', 'gstc-plugin'); ?></em></p>
<p style="font-size:.8em"><em><?php _e('This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.', 'gstc-plugin'); ?></em></p>
<p>&nbsp;</p>
</div>
<?php
?>