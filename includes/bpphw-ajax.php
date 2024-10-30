<?php
/*
* @package bp-profile-home-widgets
*/

if(!defined('ABSPATH')) {
	exit;
}


//AJAX add video
function bpphw_moveable_widgets() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	
	$widget_positions = $_POST['positions'];

	if ( ! is_array( $widget_positions ) || empty( $widget_positions ) ) {
		
		esc_attr_e( 'Input data incorrect', 'bp-profile-home-widgets');
		die();
		
	}

	$user_id = get_current_user_id();
	
	if ( $user_id != bp_displayed_user_id() ) {
		esc_attr_e( 'Not correct user', 'bp-profile-home-widgets' );
		die();
	}

	$old_widget_data = get_user_meta( $user_id, 'bpphw_widget_data' );
	$old_widget_data = $old_widget_data[0];
	$widgets = array( 'video_1', 'video_2', 'text_1', 'text_2', 'video_1', 'video_2', 'groups', 'frends', 'followers,', 'followed', 'activity', 'mentions' );
	foreach ( $widget_positions as $widget ) {
		$widget_name = sanitize_text_field($widget[0]);
		$widget_position = sanitize_text_field($widget[1]);
		if ( in_array ( $widget_name, $widgets ) ) {
			$old_widget_data[$widget_name]['position'] = $widget_position;
		}
	}
	
	$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
	
	if ( $update ) {
		
		esc_attr_e( 'Success', 'bp-profile-home-widgets');
	
	} else {
		
		esc_attr_e( 'Failed', 'bp-profile-home-widgets');
	
	}

	die();

}

add_action( 'wp_ajax_bpphw_moveable_widgets', 'bpphw_moveable_widgets');

function bpphw_reset_widget() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	
	$user_id = (int) sanitize_text_field($_POST['userId']);
	
	$widget_defaults = bpphw_get_defaults();

	if ( $user_id != bp_displayed_user_id() ) {
		
		return;
		die();
		
	}
	
	if ( isset( $user_id ) && is_numeric( $user_id ) ) {
		
		$update = update_user_meta( $user_id, 'bpphw_widget_data', $widget_defaults );
		
	} else {
		
		$update = 0;
		
	}

	echo esc_attr($update);

	die();

}

add_action( 'wp_ajax_bpphw_reset_widget', 'bpphw_reset_widget');

// Clear widget
function bpphw_clear_widget() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	
	$user_id = (int) sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	
	$old_widget_data = get_user_meta( $user_id, 'bpphw_widget_data' );
	$old_widget_data = $old_widget_data[0];
	
	$defaults = bpphw_get_defaults();

	if ( bp_loggedin_user_id() != bp_displayed_user_id() ) {
		
		return;
		die();
		
	}
	
	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) ) {
		$video_widgets = bpphw_get_widgets( 'video');
		$text_widgets = bpphw_get_widgets( 'text');
		$follow_widgets = bpphw_get_widgets( 'follow');
		$buddypress_widgets = bpphw_get_widgets( 'buddypress');
		$wordpress_widgets = bpphw_get_widgets( 'wordpress');
		if ( in_array ( $widget_name, $video_widgets ) ) {
			$old_widget_data[$widget_name]['autoplay'] = 0;
			$old_widget_data[$widget_name]['link'] = '';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $text_widgets ) ) {
			$old_widget_data[$widget_name]['content'] = '';
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $follow_widgets ) ) {
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $buddypress_widgets ) ) {
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		} else if ( in_array( $widget_name, $wordpress_widgets ) ) {
			$old_widget_data[$widget_name]['visibility'] = 'none';
			$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
			$old_widget_data[$widget_name]['img_size'] = $defaults[$widget_name]['img_size'];
			$old_widget_data[$widget_name]['max_posts'] = $defaults[$widget_name]['max_posts'];
			$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		}
		
	} else {
		
		$update = 0;
		
	}

	echo esc_attr($update);

	die();

}

add_action( 'wp_ajax_bpphw_clear_widget', 'bpphw_clear_widget');

//AJAX add video
function bpphw_add_video() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	
	if ( bp_loggedin_user_id() != bp_displayed_user_id() ) {
		
		return;
		die();
		
	}

	global $bp, $bpphw_video_width;
	
	$user_id = sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	$video_url = esc_url_raw($_POST['videoURL']);
	$widget_title = sanitize_text_field($_POST['title']);
	
	$old_widget_data = get_user_meta( $user_id, 'bpphw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) && isset( $video_url ) && bpphw_check_url( $video_url ) ) {
		
		$old_widget_data[$widget_name]['link'] = $video_url;
		$old_widget_data[$widget_name]['title'] = $widget_title;
		$old_widget_data[$widget_name]['visibility'] = 'block';
		$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}
	
	if ( $update ) {
		$width = get_option ( 'bpphw_widget_options' );
		$output = bpphw_get_video_content( $user_id, $video_url, $widget_name, $width );
	} else {
		$output = esc_attr__( 'Video not saved', 'bp-profile-home-widgets' );
	}

	echo $output;

	die();

}

add_action( 'wp_ajax_bpphw_add_video', 'bpphw_add_video');

//AJAX add text and make clickable
function bpphw_add_text() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	
	global $bp;
	
	$user_id = sanitize_text_field($_POST['userId']);
	$widget_name = sanitize_text_field($_POST['name']);
	$widget_title = sanitize_text_field($_POST['title']);
	$text_content = wp_filter_post_kses( $_POST['content'] );
	$text_content = nl2br( make_clickable( $text_content ) );
	$old_widget_data = get_user_meta( $user_id, 'bpphw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	if ( bp_loggedin_user_id() != bp_displayed_user_id() ) {
		
		return;
		die();
		
	}

	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) && isset( $text_content ) ) {
		
		$old_widget_data[$widget_name]['content'] = $text_content;
		$old_widget_data[$widget_name]['title'] = $widget_title;
		$old_widget_data[$widget_name]['visibility'] = 'block';
		$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}

	if ( $update ) {
		$output = do_shortcode( str_replace( "\'", "'", $text_content ) ); 
	} else {
		$output = '';
	}

	echo $output;

	die();

}

add_action( 'wp_ajax_bpphw_add_text', 'bpphw_add_text');

//AJAX add text and make clickable
function bpphw_add_follow() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	
	if ( bp_loggedin_user_id() != bp_displayed_user_id() ) {
		
		return;
		die();
		
	}

	$user_id = esc_attr($_POST['userId']);
	$widget_name = esc_attr($_POST['name']);
	$widget_title = esc_attr($_POST['title']);
	$max = esc_attr( $_POST['max'] );
	$img_size = esc_attr( $_POST['imgSize'] );
	$avatar_size = esc_attr( $_POST['avatarSize'] );
	$old_widget_data = get_user_meta( $user_id, 'bpphw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) ) {
		
		if ( $widget_name == 'following' || $widget_name == 'followed' || $widget_name == 'friends' ) {
			$old_widget_data[$widget_name]['max_users'] = $max;
			$old_widget_data[$widget_name]['avatar_size'] = $avatar_size;
		} else if ( $widget_name == 'groups' ) {
			$old_widget_data[$widget_name]['max_groups'] = $max;
			$old_widget_data[$widget_name]['avatar_size'] = $avatar_size;
		} else if ( $widget_name == 'posts' ) {
			$old_widget_data[$widget_name]['max_posts'] = $max;
			$old_widget_data[$widget_name]['img_size'] = $img_size;
		} else if ( $widget_name == 'activity' || $widget_name == 'mentions' ) {
			$old_widget_data[$widget_name]['max_posts'] = $max;
			$old_widget_data[$widget_name]['avatar_size'] = $avatar_size;
		}
		$old_widget_data[$widget_name]['title'] = $widget_title;
		$old_widget_data[$widget_name]['visibility'] = 'block';
		$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}

	if ( $update && $widget_name == 'following') {
		$output = bpphw_get_follow_output( $user_id, $max, $avatar_size, 'following' ); 
	} else if ( $update && $widget_name == 'followed') {
		$output = bpphw_get_follow_output( $user_id, $max. $avatar_size, 'followers' ); 
	} else if ( $update && $widget_name == 'friends') {
		$output = bpphw_get_friends_output( $user_id, $max, $avatar_size ); 
	} else if ( $update && $widget_name == 'groups') {
		$output = bpphw_get_groups_output( $user_id, $max, $avatar_size, 10 ); 
	} else if ( $update && $widget_name == 'posts') {
		$output = bpphw_get_posts_output( $user_id, $max, $img_size ); 
	} else if ( $update && $widget_name == 'activity') {
		$output = bpphw_get_activity_output( $user_id, $max, $avatar_size ); 
	} else if ( $update && $widget_name == 'mentions') {
		$output = bpphw_get_activity_output( $user_id, $max, $avatar_size, 'mentions' ); 
	} else if ( $update && $widget_name == 'mention_me') {
		$output = bpphw_get_mention_me_output(); 
	} else {
		$output = 0;
	}

	echo $output . ' ' . $widget_name . ' ' . $update;

	die();

}

add_action( 'wp_ajax_bpphw_add_follow', 'bpphw_add_follow');

// Clear text
function bpphw_clear_text() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	
	$user_id = (int) esc_attr($_POST['userId']);
	$widget_name = esc_attr($_POST['name']);
	
	$old_widget_data = get_user_meta( $user_id, 'bpphw_widget_data' );
	$old_widget_data = $old_widget_data[0];

	$defaults = bpphw_get_defaults();

	if ( bp_loggedin_user_id() != bp_displayed_user_id() ) {
		
		return;
		die();
		
	}
	
	if ( isset( $user_id ) && is_numeric( $user_id ) && isset( $widget_name ) ) {
		
		$old_widget_data[$widget_name]['content'] = '';
		$old_widget_data[$widget_name]['visibility'] = 'none';
		$old_widget_data[$widget_name]['title'] = $defaults[$widget_name]['title'];
		$update = update_user_meta( $user_id, 'bpphw_widget_data', $old_widget_data );
		
	} else {
		
		$update = 0;
		
	}

	echo esc_attr($update);

	die();

}

add_action( 'wp_ajax_bpphw_clear_text', 'bpphw_clear_widget');


//Check submitted URL for correct formatting
function bpphw_check_url( $url ) {
	
    $path = parse_url($url, PHP_URL_PATH);
    $encoded_path = array_map('urlencode', explode('/', $path));
    $url = str_replace($path, implode('/', $encoded_path), $url);

    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}
	
function bpphw_update_presets() {
	
	wp_verify_nonce( $_POST['security'], 'bpphw-nonce');
	$action = sanitize_text_field( $_POST['update'] );
	
	if ( isset( $action ) && $action === 'save' ) {
		if ( current_user_can( 'manage_options' ) ) {
			
			$user_id = bp_loggedin_user_id();
			$presets = get_user_meta( $user_id, 'bpphw_widget_data');
			update_option( 'bpphw_presets', $presets );
			echo 1;
			die();
		
		}
	
	} else if ( isset( $action ) && $action === 'clear' ) {
		
		if ( current_user_can( 'manage_options' ) ) {
			
			delete_option( 'bpphw_presets' );
			echo 1;
			die();
		
		}
	
	}
	
	echo 0;
	die();
	
}

add_action( 'wp_ajax_bpphw_update_presets', 'bpphw_update_presets');
	
	