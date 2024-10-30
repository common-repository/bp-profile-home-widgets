=== BP Profile Home Widgets ===
Contributors: Venutius
Tags: BuddyPress,profile,widget,BP,nouveau,home,members 
Tested up to: 6.6
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate Link: paypal.me/GeorgeChaplin
Author URI: www.buddyuser.com
Plugin URI: www.wordpress.org/plugins/bp-profile-home-widgets/

Add user editable widgets to the BP Nouveau profile home page with a widgets for text, video, posts, BuddyPress activity, mentions, friends and groups, as well as followed and followiing.

== Description ==

The ability to personalize a users own profile is an important part of a social network. This plugin is designed to deliver a key profile home page personalization feature. It's designed to work specifically with the BP Nouveau members profile home page widget area and also the BP Legacy Profile page by adding a widget area to that page for use by the plugin. Simply install the plugin and place the widget into the BP Nouveau members home widget area or the Profile Widget Areas created for Legacy Users (Profile Top and Profile Bottom).

When you enable the BP Nouveau Members Profile Home page for most users what will appear is a blank page that is set as their default landing page. BP Profile Home Widgets provides the next logical extension of the home page by allowing the site admin to place a number of user configurable widgets in the home page widget area. These can be configured as presets so that every users home-page will display some basic information even if they have not configured their own widgets.

The widget allows users to select up to two Text Widgets, two Video Widgets, My Posts, My Groups, My Friends, My Activity, My Mentions, Mention Me (profile comment form), Who I'm following and Who I'm followed By. The widget order can be easily rearranged using a simple drag and drop interface.

This is a companion plugin to BP User Widgets; whilst BP User Widgets is optimized for sidebars, BP PRofile Home Widgets is designed to be shown in wider formats.

Text Widgets - Provide a full featured TinyMCE text editor, if the use has video upload capability then the Media interface is also enabled. Shortcodes are supported.

Video Widget - Allow links from YouTube and other video hosting sites to be added.

WordPress Posts Widget - display the users latest post links and thumbnail.

The following features need BuddyPress to be active.

BuddyPress Groups - Adds a list of groups the user is a member of.

BuddyPress Friends - Adds a friends list.

BuddyPress Activity - Adds a recent activity feed.

BuddyPress Mentions - Displays any updates that mention the user.

BuddyPress Mention Me - Adds an input form pre-populated with the @user mention code to enable other users to comment to the user.

The following features need BP Follow to be active.

Who I'm following  - Lists recently active members the user is following.

Who's Following Me - Lists recently active followers.


Presets - Site Admin can configure their own default settings to be displayed on any members profile that has not configured their own widgets, to make sure blank pages are not shown as the members default landing page in the case of the Nouveau home page.

For the Legacy Template, once you have enabled these profile widgets you may like to make the profile page the default landing page rather than the standard Activity, to do this simply add the following line to bp-custom.php in plugins/buddypress:

/**
 * Change BuddyPress default Members landing tab.
 */
define('BP_DEFAULT_COMPONENT', 'profile' );

Other plugins that help with profile personalization are: 
* <a href="https://wordpress.org/plugins/bp-user-widgets/">BP User Widgets</a> 
* <a href="https://buddydev.com/plugins/bp-custom-background-for-user-profile/">BP Custom Background for User Profile</a> 

== Installation ==

Option 1.

1. From the Admin>>Plugins>>Add New page, search for BP Profile Home Widgets.
2. When you have located the plugin, click on "Install" and then "Activate".
3. Go to the Appearance/Widgets page and add the BP Profile Home Widget to the BuddyPress member home widget area,
4. All users will be able to go to their profile home page and add their widgets!

With the zip file:

Option 2

1. Upzip the plugin into it's directory/file structure
2. Upload BP Profile Home Widgets structure to the /wp-content/plugins/ directory.
3. Activate the plugin through the Admin>>Plugins menu.
4. Go to the Appearance/Widgets page and add the BP Profile Home Widgets to the BuddyPress members home widget area,
5. All users will be able to go to their profile home page and add their widgets!

Option 3

1. Go to Admin>>Plugins>>Add New>>Upload page.
2. Select the zip file and choose upload.
3. Activate the plugin.
4. Go to the Appearance/Widgets page and add the BP Profile Home Widgets to the BuddyPress members home widget area,
5. All users will be able to go to their profile home page and add their widgets!
 

== Frequently Asked Questions ==


== Changelog ==

= 1.2.0 =

* 22/07/2024

* Update: Escaping and translation improvements
* Upgrade: Image size options added.

= 1.1.6 =

* 07/01/2021

* Fix: Corrected error caused when no presets are set.

= 1.1.5 =

* 05/04/2019

* Fix: Added jQuery dependency.

= 1.1.4 =

* 22/02/2019

* Fix: Corrected error in adding the presets to new groups.

= 1.1.3 =

* 22/02/2019

* Fix: Adjusted widget left margin to take full width of the output area.
* Fix: Refactored mentions code to use the activity output function.
* Fix: Refactored Mention Me post form.
* Fix: corrected incorrect tabbed output on Mention Me form.
* Fix: Refactored Follow Output functions into one.

= 1.1.2 =

* 21/02/2019

* Fix: moved move icon to title.

= 1.1.1 =

* 21/02/2019

* Fix: Updated Profile widget areas to only display for BP Legacy enabled sites.
* Fix: added margins to widgets.
* Fix: Made videos responsive.

= 1.1.0 =

* 20/02/2019

* New: multiple changes to layout of widgets based on user feedback from @propertytips.
* Fix: Updated comments widget for BP Legacy.
* New: added profile top and profile bottom widget locations for legacy.

= 1.0.1 =

* 20/02/2019

* Fix: Corrected My Activity output for legacy themes.

= 1.0.0 = 

* 18/02/2019

* Initial version


== Screenshots ==

1. screenshot-1.png Widget Admin Controls

== Upgrade Notice ==

