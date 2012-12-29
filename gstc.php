<?php
/*
Plugin Name: Greg's Show Total Conversations
Plugin URI: http://gregsplugins.com/lib/plugin-details/gregs-show-total-conversations/
Description: For WordPress 2.7 and above, this plugin displays the total number of threaded discussions contained within a post's comments.
Version: 1.2.8
Author: Greg Mulhauser
Author URI: http://gregsplugins.com
*/

/*  Greg's Show Total Conversations
	
	Copyright (c) 2009-2012 Greg Mulhauser
	http://gregsplugins.com
	
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

class gregsShowTotalConversations {

	var $plugin_prefix;        // prefix for options
	var $plugin_version;       // what's our version number?
	var $our_name;             // who are we?
	var $consolidate;          // whether we'll be consolidating our options into single array, or keeping discrete
	var $our_url;              // what's our URL?

	function gregsShowTotalConversations($plugin_prefix='',$plugin_version='',$our_name='',$our_url='',$option_style='') {
		$this->__construct($plugin_prefix,$plugin_version,$our_name,$our_url,$option_style);
		return;
	} 

	function __construct($plugin_prefix='',$plugin_version='',$our_name='',$our_url='',$option_style='') {
		$this->plugin_prefix = $plugin_prefix;
		$this->plugin_version = $plugin_version;
		$this->our_name = $our_name;
		$this->our_url = $our_url;
		if (!empty($option_style)) $this->consolidate = ('consolidate' == $option_style) ? true : false;
		else $this->consolidate = true;
		add_action('wp_footer', array(&$this,'do_thank_you'));
		add_action('comments_number', array(&$this,'add_discussions'));
		add_action('admin_head', array(&$this,'comment_column_css') );
		return;
	} // end constructor

	// grab a setting
	function opt($name) {
		$prefix = rtrim($this->plugin_prefix, '_');
		// try getting consolidated settings
		if ($this->consolidate) $settings = get_option($prefix . '_settings');
		// is_array test will fail if settings not consolidated, isset will fail for private option not in array
		if (is_array($settings)) $value = (isset($settings[$name])) ? $settings[$name] : get_option($prefix . '_' . $name);
		// get discrete-style settings instead
		else $value = get_option($prefix . '_' . $name);
		return $value;
	} // end option retriever
	
	// grab a setting and tidy it up
	function opt_clean($name) {
		return stripslashes(wp_specialchars_decode($this->opt($name),ENT_QUOTES));
	} // end clean option retriever
	
	function show_discussions_number($zero = false, $one = false, $more = false) {
		if ((!get_option('thread_comments')) || (get_option('thread_comments_depth') < 2)) return; // if no threading, don't bother
		global $post,$wpdb;
		// get an array of all top level comment IDs, passing in post->ID as an argument for wpdb->prepare pedantry (better escape those integers!)
		$discussions = $wpdb->get_results($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = 1 AND comment_parent = 0" , $post->ID));
		if ($discussions == '') return;
		$countarray = array();
		foreach ($discussions as $thread) {
			// now for each of those, get an array of at most 1 comment which has that comment as a parent, passing in post->ID and thread->comment_ID as arguments for wpdb->prepare pedantry (better escape those integers!)
			$children = $wpdb->get_results($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = 1 AND comment_parent = %d ORDER BY comment_date_gmt DESC LIMIT 1", $post->ID, $thread->comment_ID));
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
		}
		else { // don't do anything if set to auto-display
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
		}
		else {
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
		// don't use plugin_basename -- buggy when using symbolic links
		$dir = basename(dirname( __FILE__)) . '/';
		$base = basename( __FILE__);
		$location_full = WP_PLUGIN_DIR . '/' . $dir . $base;
		$location_local = $dir . $base;
		$args = compact('prefix','location_full','location_local');
		$options_page_details = array (__('Greg&#8217;s Show Total Conversations Options', 'gstc-plugin'),__('Show Total Conversations', 'gstc-plugin'),'gregs-show-total-conversations/gstc-options.php');
		new gstcSetupHandler($args,$options_page_details);
	} // end setup function
	gstc_setup_setngo();
} // end admin-only stuff

// Note the following is not wrapped in an 'else' because the plugin adds functionalty to the admin pages as well

$gstc_instance = new gregsShowTotalConversations('gstc', '1.2.8', "Greg's Show Total Conversations", 'http://gregsplugins.com/lib/plugin-details/gregs-show-total-conversations/');

function gstc_show_discussions_number_manually($zero=false, $one=false, $more=false) {
	global $gstc_instance;
	$gstc_instance->show_discussions_number_manually($zero, $one, $more);
	return;
} // end show limit box manually

?>