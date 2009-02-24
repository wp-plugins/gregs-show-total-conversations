<?php
/*
Plugin Name: Greg's Show Total Conversations
Plugin URI: http://counsellingresource.com/features/2009/02/16/show-total-conversations
Description: For WordPress 2.7 and above, this plugin displays the total number of threaded discussions contained within a post's comments.
Version: 1.0.1
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
function gstc_plugin_activate() {
add_option("gstc_auto_admin", "0");
add_option("gstc_auto_post", "1");
add_option("gstc_auto_index", "0");
add_option("gstc_auto_archive", "0");
add_option("gstc_style_override", "0");
add_option("gstc_zero", '');
add_option("gstc_one", __('&nbsp;(Including One Discussion Thread)','gstc-plugin'));
add_option("gstc_more", __('&nbsp;(Including % Discussion Threads) ','gstc-plugin'));
add_option("gstc_thank_you", "0");
add_option("gstc_thank_you_message", "Thanks to %THIS_PLUGIN%.");
}
function gstc_admin_init(){
register_setting('gstc_options', 'gstc_auto_admin', 'intval');
register_setting('gstc_options', 'gstc_auto_post', 'intval');
register_setting('gstc_options', 'gstc_auto_index', 'intval');
register_setting('gstc_options', 'gstc_auto_archive', 'intval');
register_setting('gstc_options', 'gstc_style_override', 'intval');
register_setting('gstc_options', 'gstc_zero', 'htmlspecialchars');
register_setting('gstc_options', 'gstc_one', 'htmlspecialchars');
register_setting('gstc_options', 'gstc_more', 'htmlspecialchars');
register_setting('gstc_options', 'gstc_thank_you', 'intval');
register_setting('gstc_options', 'gstc_thank_you_message', 'wp_filter_nohtml_kses');
}
function gstc_plugin_menu() {
add_options_page(__('Show Total Conversations Options', 'gstc-plugin'), __('Show Total Conversations', 'gstc-plugin'), 'manage_options', 'gregs-show-total-conversations/gstc-options.php') ;
}
function gstc_show_discussions_number($zero = false, $one = false, $more = false) {
if ((!get_option('thread_comments')) || (get_option('thread_comments_depth') < 2)) return; 
global $post,$wpdb;
$discussions = $wpdb->get_results($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = " . $post->ID . " AND comment_approved = 1 AND comment_parent = 0" ));
if ($discussions == '') return;
$countarray = array();
foreach ($discussions as $thread) {
$children = $wpdb->get_results($wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = " . $post->ID . " AND comment_approved = 1 AND comment_parent = " . $thread->comment_ID . " ORDER BY comment_date_gmt DESC LIMIT 1"));
$countarray = array_merge($countarray,$children);
}
$countarray = count($countarray); 
if ($countarray > 1)
$output = str_replace('%', number_format_i18n($countarray), ( false === $more ) ? __(' (Including % Discussion Threads) ','gstc-plugin') : $more);
elseif ( $countarray == 0 )
$output = ( false === $zero ) ? __('','gstc-plugin') : $zero;
else 
$output = ( false === $one ) ? __(' (Including One Discussion Thread)','gstc-plugin') : $one;
return $output;
}
### Function: Auto-show here
function gstc_show_here() {
$do_admin = get_option('gstc_auto_admin');
$do_post = get_option('gstc_auto_post');
$do_index = get_option('gstc_auto_index');
$do_archive = get_option('gstc_auto_archive');
if (is_admin() && ($do_admin==1)) return true;
elseif (is_single() && ($do_post==1)) return true;
elseif ((is_home() || is_front_page()) && ($do_index==1)) return true;
elseif (is_archive() && ($do_archive==1)) return true;
else return false;
} 
### Function: Show the discussion number manually
function gstc_show_discussions_number_manually($zero = false, $one = false, $more = false) {
if (!gstc_show_here() ) { 
$override = get_option('gstc_style_override');
if ($override == 1) {
$zero = wp_specialchars_decode(get_option('gstc_zero'));
$one = wp_specialchars_decode(get_option('gstc_one'));
$more = wp_specialchars_decode(get_option('gstc_more'));
} 
echo gstc_show_discussions_number($zero,$one,$more);
} else { 
return;
} 
}
function gstc_add_discussions($output) {
if (gstc_show_here() ) {
$zero = wp_specialchars_decode(get_option('gstc_zero'));
$one = wp_specialchars_decode(get_option('gstc_one'));
$more = wp_specialchars_decode(get_option('gstc_more'));
return $output . gstc_show_discussions_number($zero,$one,$more);
} else {
return $output;
} 
}
### Function: Thank you
function gstc_thanks() {
if ((get_option('gstc_thank_you') == 1) && is_single() ){ 
$message = str_replace('%THIS_PLUGIN%','<a href="http://counsellingresource.com/features/2009/02/16/show-total-conversations/">Greg&#8217;s Show Total Conversations plugin</a>',get_option('gstc_thank_you_message'));
echo '<p>' . $message . '</p>';
} 
return;
}
### Function: Widen comment column when showing on admin pages
function gstc_comment_column_css() {
$do_admin = get_option('gstc_auto_admin');
if (is_admin() && ($do_admin==1))
echo "\n" . '<style type="text/css">
table.widefat th.column-comments {width:85px;}
</style>' . "\n";
return;
}
add_filter('comments_number', 'gstc_add_discussions');
add_action('admin_menu', 'gstc_plugin_menu');
add_action( 'admin_init', 'gstc_admin_init' );
register_activation_hook( __FILE__, 'gstc_plugin_activate' );
add_action('wp_footer', 'gstc_thanks');
add_action('admin_head', 'gstc_comment_column_css');
?>