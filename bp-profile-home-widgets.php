<?php

/*
Plugin Name: BP Profile Home Widgets
Plugin URI: https://buddyuser.com/plugin-bp-profile-home-widgets
Description: BP Profile Home Widgets adds user customizable widgets to the BP Nouveau Profile Home page, allowing users to create text, video, friends, groups, activity, mentions and follow widgets specific to their home page. This plugin requires BuddyPress.
Version: 1.2.0
Text Domain: bp-profile-home-widgets
Domain Path: /langs
Author: Venutius
Author URI: https://buddyuser.com
License: GPLv2

**************************************************************************

  Copyright (C) 2021 BuddyPress User

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General License for more details.

  You should have received a copy of the GNU General License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

**************************************************************************

Widgets:
	Done: GDPR Compliance
	Done: Video Widget
	Done: Text Widget, with support for images and shortcodes
	Done: My Groups
	Done: My Friends
	Done: My Posts
	Done: My Activity
	Done: My Mentions
	Done: My Following / Followers
	Done: Mention Me

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bpphw_enqueue_scripts() {
	wp_register_script( 'bpphw-translation', plugins_url( 'js/bpphw-fronntend5.js', __FILE__ ), array( 'jquery' ),'', true );
	wp_enqueue_style( 'bpphw_jquery_style', plugins_url( 'vendor/jquery/jquery-ui.css', __FILE__ ), array(),'', true );
	
	$translation_array = array(
		'video_1'				=> sanitize_text_field(esc_attr__( 'Video/Audio 1', 'bp-profile-home-widgets') ),
		'video_2'				=> sanitize_text_field(esc_attr__( 'Video/Audio 2', 'bp-profile-home-widgets') ),
		'text_1'				=> sanitize_text_field(esc_attr__( 'Text 1', 'bp-profile-home-widgets') ),
		'text_2'				=> sanitize_text_field(esc_attr__( 'Text 2', 'bp-profile-home-widgets') ),
		'followed'				=> sanitize_text_field(esc_attr__( 'Followed', 'bp-profile-home-widgets') ),
		'following'				=> sanitize_text_field(esc_attr__( 'Following', 'bp-profile-home-widgets') ),
		'friends'				=> sanitize_text_field(esc_attr__( 'My Friends', 'bp-profile-home-widgets') ),
		'groups'				=> sanitize_text_field(esc_attr__( 'My Groups', 'bp-profile-home-widgets') ),
		'activity'				=> sanitize_text_field(esc_attr__( 'My Activity', 'bp-profile-home-widgets') ),
		'mentions'				=> sanitize_text_field(esc_attr__( 'My Mentions', 'bp-profile-home-widgets') ),
		'mention_me'			=> sanitize_text_field(esc_attr__( 'Mention Me', 'bp-profile-home-widgets') ),
		'resetWidget'			=> sanitize_text_field( esc_attr__( 'Resetting to defaults...', 'bp-profile-home-widgets' ) ),
		'submit'				=> sanitize_text_field( esc_attr__( 'Submit', 'bp-profile-home-widgets' ) ),
		'add'					=> sanitize_text_field( esc_attr__( 'Add Widget', 'bp-profile-home-widgets' ) ),
		'change' 				=> sanitize_text_field( esc_attr__( 'Change', 'bp-profile-home-widgets' ) ),
		'cancel'				=> sanitize_text_field( esc_attr__( 'Cancel', 'bp-profile-home-widgets' ) ),
		'success'				=> sanitize_text_field( esc_attr__( 'Success!', 'bp-profile-home-widgets' ) ),
		'successRefresh'		=> sanitize_text_field( esc_attr__( 'Success! Please refresh the window to see.', 'bp-profile-home-widgets' ) ),
		'tryAgain'				=> sanitize_text_field( esc_attr__( 'Please try again...', 'bp-profile-home-widgets' ) ),
		'enterVideo'			=> sanitize_text_field( esc_attr__( 'Please paste a URL', 'bp-profile-home-widgets' ) ),
		'addingVideo'			=> sanitize_text_field( esc_attr__( 'Adding Video ...', 'bp-profile-home-widgets' ) ),
		'addingFriends'			=> sanitize_text_field( esc_attr__( 'Adding Friends ...', 'bp-profile-home-widgets' ) ),
		'addingGroups'			=> sanitize_text_field( esc_attr__( 'Adding Groups ...', 'bp-profile-home-widgets' ) ),
		'addingActivity'		=> sanitize_text_field( esc_attr__( 'Adding Activity ...', 'bp-profile-home-widgets' ) ),
		'addingMentions'		=> sanitize_text_field( esc_attr__( 'Adding Mentions ...', 'bp-profile-home-widgets' ) ),
		'addingMentionMe'		=> sanitize_text_field( esc_attr__( 'Adding Mention Me ...', 'bp-profile-home-widgets' ) ),
		'addingPosts'			=> sanitize_text_field( esc_attr__( 'Adding Posts ...', 'bp-profile-home-widgets' ) ),
		'addingFollowing'		=> sanitize_text_field( esc_attr__( 'Adding Following ...', 'bp-profile-home-widgets' ) ),
		'addingFollowers'		=> sanitize_text_field( esc_attr__( 'Adding Followers ...', 'bp-profile-home-widgets' ) ),
		'addingVideo'			=> sanitize_text_field( esc_attr__( 'Adding Video ...', 'bp-profile-home-widgets' ) ),
		'deleting'				=> sanitize_text_field( esc_attr__( 'Deleting...', 'bp-profile-home-widgets' ) ),
		'clearPreset'			=> sanitize_text_field(esc_attr__( 'Clear Preset', 'bp-profile-home-widgets' ) ),
		'savePreset'			=> sanitize_text_field(esc_attr__( 'Save as Preset', 'bp-profile-home-widgets' ) ),
		'clearingPreset'		=> sanitize_text_field(esc_attr__( 'Clearing Preset...', 'bp-profile-home-widgets' ) ),
		'savingPreset'			=> sanitize_text_field(esc_attr__( 'Saving as Preset...', 'bp-profile-home-widgets' ) ),
		'addingText'			=> sanitize_text_field( esc_attr__( 'Adding Text ...', 'bp-profile-home-widgets' ) )
		);
	
	wp_localize_script( 'bpphw-translation', 'bpphw_translate', $translation_array );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-widget' );
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'jquery-ui-draggable' );
    wp_enqueue_script( 'jquery-ui-droppable' );
	wp_enqueue_script( 'bpphw-translation');

	wp_localize_script( 'bpphw-translation', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php'), 'check_nonce' => wp_create_nonce('bpphw-nonce') ) );
	wp_enqueue_style( 'bpphw_style', plugins_url( 'vendor/jquery/jquery-ui.css', __FILE__ ) );
	wp_enqueue_style( 'bpphw_style', plugin_dir_path( 'css/bpphw.css', __FILE__) );

}
add_action( 'wp_enqueue_scripts', 'bpphw_enqueue_scripts' );

// Localization
function bpphw_localization() {

load_plugin_textdomain('bp-profile-home-widgets', false, dirname(plugin_basename( __FILE__ ) ).'/langs/' );
}
 
add_action('init', 'bpphw_localization');

// Load Ajax

include_once( plugin_dir_path(__FILE__) . '/includes/bpphw-ajax.php' );

// Load Widget Class

include_once( plugin_dir_path(__FILE__) . '/includes/bpphw-widget-class.php' );

// Load Functions

include_once( plugin_dir_path(__FILE__) . '/includes/bpphw-functions.php' );

// Register Widget

function bpphw_register_widget() {
	
	register_widget( 'BP_Profile_Home_Widgets' );
	
}

add_action( 'widgets_init', 'bpphw_register_widget' );


?>