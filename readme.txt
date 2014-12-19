=== Greg's Show Total Conversations ===
Contributors: GregMulhauser
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661
Tags: comments, count, numbering, threading, threaded comments, display, comments.php, greg mulhauser, comment number, comment counter, listing comments, discussions, conversations
Requires at least: 2.7
Tested up to: 4.1
Stable tag: 1.3.3
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin displays the total number of threaded conversations contained within a post's comments. Coders can call the function directly.

== Description ==

**NOTE:** Please do NOT use the WordPress forums to seek support for this plugin. Support for GSTC is handled on [our own site](http://gregsplugins.com/lib/faq/).

WordPress provides a built-in function to display the total number of comments on a given post; this plugin extends that functionality to show the number of separate threaded discussions included within that total. No theme modifications are required.

= New in This Version =

* Note on WordPress 4.1 compatibility.

= Background =

WordPress 2.7 introduced native comment threading, enabling your blog's readers to reply directly to one another's comments. But while WordPress keeps track of the total number of comments on a given post, providing a function which theme creators can use to show that total, it doesn't offer any easy way to track how many of the comments have wound up initiating threaded conversations.

This plugin counts those conversation threads for you and displays the total -- with no theme modifications required. You can even choose to show conversation totals on your post and comment admin pages.

For extra flexibility, coders can also tap into the plugin's core function directly.

This plugin counts any sequence of threaded replies to a top-level comment as a single 'conversation'. However many times a conversation might branch off into further threaded replies, the plugin still counts it just once.

For more information, please see the 'Instructions' tab available from this plugin's admin interface.

== Installation ==

**NOTE:** Please do NOT use the WordPress forums to seek support for this plugin. Support for GSTC is handled on [our own site](http://gregsplugins.com/lib/faq/).

1. Unzip the plugin archive
2. Upload the entire folder `gregs-show-total-conversations` to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Settings -> Show Total Conversations to configure your preferences

= Usage =

No theme modifications are required to use this plugin -- the plugin's settings page enables you to specify which pages should include a conversation total. If you'd like more flexibility, however, you can call the plugin's core function directly.

*Basic Usage*

Just enable the plugin and visit Settings -> Show Total Conversations to configure your preferences.

*Advanced Usage*

You can show the conversations total by calling the following function directly, preferably wrapped in a conditional which tests whether the function exists (i.e., tests whether the plugin is enabled):

`<?php gstc_show_discussions_number_manually(); ?>`

This function takes optional parameters specifying your preferred message for zero conversations, one conversation, or more than one conversation. The parameters work exactly like those for the built-in WordPress function `comments_number`:

`<?php gstc_show_discussions_number_manually($zero, $one, $more); ?>`

The character `%` in the parameter `$more` will be replaced with the conversation total.

= Deactivating and Uninstalling =

You can deactivate Greg's Show Total Conversations plugin via the plugins administration page, and your preferences will be saved for the next time you enable it.

However, if you would like to remove the plugin completely, just disable it via the plugins administration page, then select it from the list of recently deactivated plugins and choose "Delete" from the admin menu. This will not only delete the plugin, but will also run a special routine included with the plugin which will completely remove its preferences from the database.

== Frequently Asked Questions ==

**NOTE:** Please do NOT use the WordPress forums to seek support for this plugin. Support for GSTC is handled on [our own site](http://gregsplugins.com/lib/faq/).

== Screenshots ==

1. Total conversations number displayed with the WordPress default theme
2. Greg's Show Total Conversations settings page

== Upgrade Notice ==

= 1.3.3, 19 December 2014 =
* Note on WordPress 4.1 compatibility.

== Changelog ==

= 1.3.3, 19 December 2014 =
* Note on WordPress 4.1 compatibility.

= 1.3.2, 8 October 2014 =
* Documentation update and note on WordPress 4.0 compatibility.

= 1.3.1, 23 April 2014 =
* Noted compatibility with WordPress 3.9.

= 1.3, 22 November 2013 =
* Dropped compatibility with very old versions of PHP no longer supported by WordPress.

= 1.2.9, 21 September 2013 =
* Updated WordPress version compatibility.

= 1.2.8, 29 December 2012 =
* Tweaked wpdb->prepare for better 3.5 compatibility -- because you never know when you might meet an integer that needs escaping...

= 1.2.7, 15 December 2012 =
* Replaced some ancient admin page code to enable loading the plugin through a symbolic link.
* Confirmed 3.5 compatibility.

= 1.2.6, 26 November 2011 =
* Removed PluginSponsors.com code following threats that the plugin would be expelled from the plugin repository for using the code to display sponsorship messages

= 1.2.5, 27 October 2011 =
* Documentation updates

= 1.2.4, 3 October 2011 =
* Minor code cleanups

= 1.2.3, 20 January 2011 =
* Minor code cleanup
* Testing with WP 3.1 Release Candidate 2

= 1.2.2, 24 June 2010 =
* Better workaround for WordPress 3.0's problems initialising plugins properly under multisite

= 1.2.1, 24 June 2010 =
* Workaround for rare problem where WordPress interferes with a newly activated plugin's ability to add options when using multisite/network mode

= 1.2, 1 June 2010 =
* Major reduction in database footprint in preparation for WordPress 3.0

= 1.1.9, 20 April 2010 =
* Minor code cleanups

= 1.1.8, 6 April 2010 =
* Enhanced admin pages now support user-configurable section boxes which can be re-ordered or closed

= 1.1.7, 12 January 2010 =
* Fully tested with 2.9.1 (no changes)

= 1.1.6, 10 November 2009 =
* Minor update to configuration pages
* Fully tested with 2.8.5 (no changes)

= 1.1.5, 17 August 2009 =
* Options page bugfix for users on old PHP4 installations

= 1.1.4, 12 August 2009 =
* Documentation tweaks
* Added support for [Plugin Sponsorship](http://pluginsponsors.com/)
* Fully tested with 2.8.4 (no changes)

= 1.1.3, 19 June 2009 =
* Now supports conversation counting on pages as well as posts -- thanks to Marina

= 1.1.2, 11 June 2009 =
* Fully tested with final release of WordPress 2.8

= 1.1.1, 15 April 2009 =
* Fixed a minor typo which would have interfered with translations for this plugin -- thanks to Nikolay

= 1.1, 3 April 2009 =
* This version brings higher performance, several minor enhancements, and a revamped administrative interface; it is recommended for all users.

= 1.0.1, 24 February 2009 =
* Work-around for WordPress 2.7's broken implementation of htmlspecialchars_decode for PHP4 users

= 1.0, 16 February 2009 =
* Initial public release
* Thanks to Marina for the suggestion!

== Fine Print ==

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License version 3 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.