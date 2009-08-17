<?php
/*
Plugin Name: Greg's Show Total Conversations
Plugin URI: http://counsellingresource.com/features/2009/02/16/show-total-conversations
Description: For WordPress 2.7 and above, this plugin displays the total number of threaded discussions contained within a post's comments.
Version: 1.1.5
Author: Greg Mulhauser
Author URI: http://counsellingresource.com
*/

/*  Copyright 2009 Greg Mulhauser

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class gregsShowTotalConversations {

var $plugin_prefix; // prefix for option names
var $plugin_version; // what's our version number?
var $our_name; // who are we?
var $our_url; // what's our URL?

function gregsShowTotalConversations($plugin_prefix='',$plugin_version='',$our_name='',$our_url='') {
$this->__construct($plugin_prefix,$plugin_version,$our_name,$our_url);
return;
} 

function __construct($plugin_prefix='',$plugin_version='',$our_name='',$our_url='') {
$this->plugin_prefix = $plugin_prefix;
$this->plugin_version = $plugin_version;
$this->our_name = $our_name;
$this->our_url = $our_url;
add_action('wp_footer', array(&$this,'do_thank_you'));
add_action('comments_number', array(&$this,'add_discussions'));
add_action('admin_head', array(&$this,'comment_column_css') );
return;
} // end constructor


function opt($name) {
return get_option($this->plugin_prefix . '_' . $name);
} // end option retriever

function opt_clean($name) {
return stripslashes(wp_specialchars_decode($this->opt($name),ENT_QUOTES));
} // end clean option retriever

function show_discussions_number($zero = false, $one = false, $more = false) {
if ((!get_option('thread_comments')) || (get_option('thread_comments_depth') < 2)) return; // if no threading, don't bother
global $post,$wpdb;
// get an array of all top level comment IDs
$discussions = $wpdb->get_results($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = " . $post->ID . " AND comment_approved = 1 AND comment_parent = 0" ));
if ($discussions == '') return;
$countarray = array();
foreach ($discussions as $thread) {
// now for each of those, get an array of at most 1 comment which has that comment as a parent
$children = $wpdb->get_results($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = " . $post->ID . " AND comment_approved = 1 AND comment_parent = " . $thread->comment_ID . " ORDER BY comment_date_gmt DESC LIMIT 1"));
$countarray = array_merge($countarray,$children);
}
$countarray = count($countarray); // how many were there which count a top-level comment as their parent?
if ($countarray > 1)
	$output = str_replace('%', number_format_i18n($countarray), ( false === $more ) ? $this->opt_clean('more') : $more);
elseif ( $countarray == 0 )
		$output = ( false === $zero ) ? $this->opt_clean('zero') : $zero;
else // must be one
		$output = ( false === $one ) ? $this->opt_clean('one') : $one;
return $output;
}

### Function: Auto-show here
function show_here() {
$do_admin = $this->opt('auto_admin');
$do_post = $this->opt('auto_post');
$do_index = $this->opt('auto_index');
$do_archive = $this->opt('auto_archive');
if (is_admin() && ($do_admin)) return true;
elseif ((is_single() || is_page()) && ($do_post)) return true;
elseif ((is_home() || is_front_page()) && ($do_index)) return true;
elseif (is_archive() && ($do_archive)) return true;
else return false;
} // end check for whether to show automatically

### Function: Show the discussion number manually
function show_discussions_number_manually($zero = false, $one = false, $more = false) {
if (!$this->show_here() ) { 
$override = $this->opt('style_override');
if ($override) {
$zero = $this->opt_clean('zero');
$one = $this->opt_clean('one');
$more = $this->opt_clean('more');
} // end getting styles to override
echo $this->show_discussions_number($zero,$one,$more);
} else { // don't do anything if set to auto-display
return;
} // end check whether we should show anything
return;
}

function add_discussions($output) {
if ($this->show_here() ) {
$zero = $this->opt_clean('zero');
$one = $this->opt_clean('one');
$more = $this->opt_clean('more');
return $output . $this->show_discussions_number($zero,$one,$more);
} else {
return $output;
} // end check whether we should show anything
}

### Function: Thank you
function do_thank_you() {
if (($this->opt('thank_you')) && is_single() ){
$url = $this->our_url;
$name = $this->our_name;
$replacement = '<a href="' . $url . '">' . $name . '</a>';
$message = str_replace('%THIS_PLUGIN%',$replacement,$this->opt('thank_you_message'));
echo '<p>' . $message . '</p>';
} 
return;
}

### Function: Widen comment column when showing on admin pages
function comment_column_css() {
if (is_admin() && ($this->opt('auto_admin')))
echo "\n" . '<style type="text/css">
table.widefat th.column-comments {width:85px;}
</style>' . "\n";
return;
}

} // end class definition

if (is_admin()) {
   include ('gstc-setup-functions.php');
   function gstc_setup_setngo() {
	  $prefix = 'gstc';
	  $location_full = __FILE__;
	  $location_local = plugin_basename(__FILE__);
	  $options_page_details = array (__('Greg&#8217;s Show Total Conversations Options', 'gstc-plugin'),__('Show Total Conversations', 'gstc-plugin'),'gregs-show-total-conversations/gstc-options.php');
	  new gstcSetupHandler($prefix,$location_full,$location_local,$options_page_details);
	  } // end setup function
   gstc_setup_setngo();
   } // end admin-only stuff

// Note the following is not wrapped in an 'else' because the plugin adds functionalty to the admin pages as well

$gstc_instance = new gregsShowTotalConversations('gstc', '1.1.5', "Greg's Show Total Conversations", 'http://counsellingresource.com/features/2009/02/16/show-total-conversations/');
function gstc_show_discussions_number_manually($zero=false, $one=false, $more=false) {
   global $gstc_instance;
   $gstc_instance->show_discussions_number_manually($zero, $one, $more);
   return;
   } // end show limit box manually

?>