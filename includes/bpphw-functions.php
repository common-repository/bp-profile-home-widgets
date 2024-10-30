<?php

/*
BP Profile Home Widgets Functions

Text Domain: bp-profile-home-widgets

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Load widget settings for user
function bpphw_get_widget_data( $displayed_user_id = '' ) {
	
	$widget_default_data = bpphw_get_defaults();
	
	if ( $displayed_user_id == '' ) {
	
		$displayed_user_id = bp_displayed_user_id();
		
	}
	
	$widget_data = get_user_meta( $displayed_user_id, 'bpphw_widget_data');

	// If first time access of the profile page, user settings need to be created
	if ( ! $widget_data ) {
		
		update_user_meta( $displayed_user_id, 'bpphw_widget_data', $widget_default_data );
		$widget_data = get_user_meta( $displayed_user_id, 'bpphw_widget_data');
		$widget_data = $widget_data[0];
		
	} else {
		
		$widget_data = array_merge ( $widget_default_data, $widget_data[0] );
		update_user_meta( $displayed_user_id, 'bpphw_widget_data', $widget_data );
		
	}
	
			
	
	return $widget_data;
	
}

// Establish global user defaults for user widgets
function bpphw_get_defaults() {
	
	$widget_default_data = Array (
		'video_1' => Array (
			'name' 			=> 'video_1',
			'title'			=> esc_attr__('Video/Audio Player 1', 'bp-profile-home-widgets' ),
			'visibility'	=> 'none',
			'link'			=> '',
			'autoplay'		=> 0,
			'index' 		=> 1,
			'position' 		=> 1 ),
		'video_2' => Array (
			'name' 			=> 'video_2',
			'title'			=> esc_attr__('Video/Audio Player 2', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'link'			=> '',
			'autoplay'		=> 0,
			'index' 		=> 2,
			'position' 		=> 2 ),
		'text_1' => Array (
			'name' 			=> 'text_1',
			'title'			=> esc_attr__('Text Widget 1', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'content'		=> '',
			'index' 		=> 3,
			'position' 		=> 3 ),
		'text_2' => Array (
			'name' 			=> 'text_2',
			'title'			=> esc_attr__('Text Widget 2', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'content'		=> '',
			'index' 		=> 4,
			'position' 		=> 4 ),
		'following' => Array (
			'name' 			=> 'following',
			'title'			=> esc_attr__('Who I Follow', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'max_users'		=> 10,
			'avatar_size'	=> 'full',
			'index' 		=> 5,
			'position' 		=> 5 ),
		'followed' => Array (
			'name' 			=> 'followed',
			'title'			=> esc_attr__('My Followers', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'max_users'		=> 10,
			'avatar_size'	=> 'full',
			'index' 		=> 6,
			'position' 		=> 6 ),
		'friends' => Array (
			'name' 			=> 'friends',
			'title'			=> esc_attr__('My Friends', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'max_users'		=> 10,
			'avatar_size'	=> 'full',
			'index' 		=> 7,
			'position' 		=> 7 ),
		'groups' => Array (
			'name' 			=> 'groups',
			'title'			=> esc_attr__('My Groups', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'max_groups'	=> 10,
			'avatar_size'	=> 'full',
			'index' 		=> 8,
			'position' 		=> 8 ),
		'posts' => Array (
			'name' 			=> 'posts',
			'title'			=> esc_attr__('My Posts', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'max_posts'		=> 5,
			'img_size'		=> 150,
			'index' 		=> 9,
			'position' 		=> 9 ),
		'activity' => Array (
			'name' 			=> 'activity',
			'title'			=> esc_attr__('My Activity', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'max_posts'		=> 5,
			'avatar_size'	=> 'full',
			'index' 		=> 10,
			'position' 		=> 10 ),
		'mention_me' => Array (
			'name' 			=> 'mention_me',
			'title'			=> esc_attr__('Mention Me', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'index' 		=> 11,
			'position' 		=> 11 ),
		'mentions' => Array (
			'name' 			=> 'mentions',
			'title'			=> esc_attr__('My Mentions', 'bp-profile-home-widgets' ),
			'visibility' 	=> 'none',
			'max_posts'		=> 5,
			'avatar_size'	=> 'full',
			'index' 		=> 12,
			'position' 		=> 12 )
	);
	
	$presets = get_option( 'bpphw_presets' );
	if ( $presets ) {
		$presets = $presets[0];
	}
	
	if ( $presets && is_array( $presets ) ) {
		
		return $presets;
		
	}

	
	return $widget_default_data;
	
}

function bpphw_get_widgets( $type ) {
	
	switch ( $type ) {
	
		case 'text' :
			$response = array( 'text_1', 'text_2' );
			break;

		case 'video' : 
			$response = array( 'video_1', 'video_2' );
			break;
		
		case 'follow' :
			$response = array ( 'followed', 'following' );
			break;
			
		case 'buddypress' :
			$response = array( 'friends', 'groups', 'activity', 'mentions', 'mention_me' );
			break;
			
		case 'wordpress' :
			$response = array( 'posts' );
			break;
	}
	
	return $response;
}

function bpphw_get_mention_me_output() {
	
	$template = plugin_dir_path( __DIR__ ) . 'templates/activity/post-form.php';
	ob_start();
	load_template( $template, false );
	$content = ob_get_contents();
	ob_end_clean();
	echo $content;
	
}

function bpphw_activity_get_comments( $args = '' ) {
	global $activities_template;

	if ( empty( $activities_template->activity->children ) ) {
		return false;
	}

	bpphw_activity_recurse_comments( $activities_template->activity );
}

function bpphw_activity_recurse_comments( $comment ) {
	global $activities_template;

	/**
	 * Filters the opening tag for the template that lists activity comments.
	 *
	 * @since 1.6.0
	 *
	 * @param string $value Opening tag for the HTML markup to use.
	 */
	echo apply_filters( 'bp_activity_recurse_comments_start_ul', '<ul>' );
	foreach ( (array) $comment->children as $comment_child ) {

		// Put the comment into the global so it's available to filters.
		$activities_template->activity->current_comment = $comment_child;

		$template = plugin_dir_path( __DIR__ ) . 'templates/activity/comment.php';

		load_template( $template, false );

		unset( $activities_template->activity->current_comment );
	}
}

function bpphw_get_activity_output( $user_id, $max_posts, $avatar_size, $type = 'activity' ) {
	
	if ( $type == 'activity' ) {
		$type = 'just-me';
	}
	if ( bp_has_activities( array( 'max' => $max_posts, 'scope' => $type, 'user_id' => $user_id ) )) : 
		if ( bp_get_theme_package_id() == 'nouveau' ) :
		bp_nouveau_before_loop(); ?>
		
		<?php if ( empty( $_POST['page'] ) || 1 === (int) $_POST['page'] ) : ?>
			<ul class="activity-list item-list bp-list">
		<?php endif; ?>

		<?php
		while ( bp_activities() ) :
			bp_the_activity();
		?>

			<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>" data-bp-activity-id="<?php bp_activity_id(); ?>" data-bp-timestamp="<?php bp_nouveau_activity_timestamp(); ?>">

				<div class="activity-avatar item-avatar">

					<a href="<?php bp_activity_user_link(); ?>">

						<?php bp_activity_avatar( array( 'type' => $avatar_size ) ); ?>

					</a>

				</div>

				<div class="activity-content">

					<div class="activity-header">

						<?php bp_activity_action(); ?>

					</div>

					<?php if ( bp_nouveau_activity_has_content() ) : ?>

						<div class="activity-inner">

							<?php bp_nouveau_activity_content(); ?>

						</div>

					<?php endif; ?>

					<?php if ( bp_activity_get_comment_count() || ( is_user_logged_in() && ( bp_activity_can_comment() || bp_is_single_activity() ) ) ) : ?>

						<div class="activity-comments">

							<?php bpphw_activity_get_comments(); ?>

						</div>

					<?php endif; ?>

				</div>

			</li>
		
		<?php endwhile; ?>

			</ul>
<?php 	elseif ( bp_get_theme_package_id() == 'legacy' ) :
				if ( empty( $_POST['page'] ) ) : ?>

				<ul id="activity-stream" class="activity-list item-list">

			<?php endif; ?>

			<?php
			while ( bp_activities() ) : bp_the_activity();

				bpphw_legacy_entry($avatar_size); ?>

			<?php endwhile; ?>

			<?php if ( empty( $_POST['page'] ) ) : ?>

				</ul>

			<?php endif; ?>



			<?php else : 
			


				?><div id="message" class="info">
					<p><?php ( $type = 'mentions' ) ? esc_attr_e( 'Sorry, there was no mentions found.', 'bp-profile-home-widgets' ) : esc_attr_e( 'Sorry, there was no activity found.', 'bp-profile-home-widgets' ); ?></p>
				</div>
			 <?php endif;?>
		<?php
	endif;
	
}

// BP Legacy activity entry
function bpphw_legacy_entry($avatar_size) {
	
	?>

	<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">
		<div class="activity-avatar">
			<a href="<?php bp_activity_user_link(); ?>">

				<?php bp_activity_avatar(array( 'type' => $avatar_size )); ?>

			</a>
		</div>

		<div class="activity-content">

			<div class="activity-header">

				<?php bp_activity_action(); ?>

			</div>

			<?php if ( bp_activity_has_content() ) : ?>

				<div class="activity-inner">

					<?php bp_activity_content_body(); ?>

				</div>

			<?php endif; ?>

			<div class="activity-meta">

				<?php if ( bp_get_activity_type() == 'activity_comment' ) : ?>

					<a href="<?php bp_activity_thread_permalink(); ?>" class="button view bp-secondary-action"><?php esc_attr_e( 'View Conversation', 'bp-profile-home-widgets' ); ?></a>

				<?php endif; ?>

			</div>

		</div>

		<?php if ( ( bp_activity_get_comment_count() || bp_activity_can_comment() ) || bp_is_single_activity() ) : ?>

			<div class="activity-comments">

				<?php bp_activity_comments(); ?>

			</div>

		<?php endif; ?>

	</li>

<?php
	
}


function bpphw_get_posts_output( $user_id, $max_posts, $img_size ) {
	
	$my_posts = get_posts( array( 
		'author' => $user_id, 
		'posts_per_page' => $max_posts
		) 
	);
	$show_author = false;
	$showthumbnail = true;
	
	if (count($my_posts) > 0) :
		?>
		<div style="display:flex;" class="bpphw_my_posts" >
		<?php foreach ( $my_posts as $my_post ) { ?>
			<div style="display: grid; margin-left:auto; margin-right:auto;text-align:center;">
            <?php if( $show_author ) : ?>
				<div style="margin-left:5px; margin-right:5px;">
					<div style="margin-left:auto; margin-right:auto;" class="bpphw_author" >
						 <a href="<?php echo bp_members_get_user_url( $user_id ) ; ?>">
						<?php				
						echo bp_core_fetch_avatar( array( 'item_id' => $user_id ) ); ?>				
						</a>
					</div>
				</div>
            <?php
			endif;
			if( $showthumbnail ){
				if( has_post_thumbnail( $my_post->ID )){
				?>
				<div style="margin-left:5px; margin-right:5px;">
					 <div style="margin-left:auto; margin-right:auto;" class="bpphw_thumbnail">
						 <a href="<?php echo get_permalink( $my_post->ID ) ; ?>">
						<?php				
						echo get_the_post_thumbnail($my_post->ID, $img_size); ?>				
						</a>
					</div>
				</div>
			<?php }

			}?>
            
				<div style="margin-left:5px; margin-right:5px;">
					<div style="margin-left:auto; margin-right:auto;" class="bpphw_my_posts">
						<a href="<?php echo get_permalink( $my_post->ID ) ; ?>">
						<?php			
						echo apply_filters( 'the_title', esc_attr($my_post->post_title), esc_attr($my_post->ID )); ?>
						</a>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();		
		endif ;	
	
}

// Get oembed Iframe for videos
function bpphw_get_video_content( $user_id, $url, $name, $width )	{
	$width = (int)$width;
	$service = $multiplier = $height = $control = '';

	$user_settings = get_user_meta( $user_id, 'bpphw_widget_data' );
	$user_settings = $user_settings[0];
	$autoplay = $user_settings[$name]['autoplay'];

	// Determine the height from the width in the Widget options

	$multiplier = .75; 
	
	if ( !empty( $width ) && !empty( $multiplier ) ) {
		
		if ( !empty( $url ) ) {

			$host 		= parse_url( $url, PHP_URL_HOST );
			$exp		= explode( '.', $host );
			$service 	= ( count( $exp ) >= 3 ? $exp[1] : $exp[0] );
			
		 } // End of $url check
			
		$control 	= ( $service == 'youtube' || $service == 'youtu' ? 25 : 0 );
		$height 	= ( ( $width * $multiplier ) + $control );
	
	
	} // End of empty checks

	if ( empty( $url ) || empty( $service ) ) {

	} else {

		$oembed = bpphw_oembed_transient( $url, $service, $width, $height );

		if ( !$oembed && $service == 'facebook' ) {
		
			// Input Example: https://www.facebook.com/photo.php?v=10201027508430408

			$explode = explode( '=', $url );
			$videoID = end( $explode );


			?><iframe src="https://www.facebook.com/video/embed?video_id=<?php echo $videoID; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" frameborder="0"></iframe><?php
					
		} else if ( ( !$oembed && $service == 'youtube' ) || ( !$oembed && $service == 'youtu' ) ) {
		
			// Input Example: https://www.facebook.com/photo.php?v=10201027508430408

			$explode = explode( '=', $url );
			$videoID = end( $explode );


			?><iframe width='<?php echo $width; ?>' height='<?php echo $height; ?>' src='//www.youtube.com/embed/<?php echo $videoID; ?>&loop=0&rel=0' frameborder='0' allowfullscreen></iframe><?php
					
		} else {

			// Input Examples: 
			// 		http://www.youtube.com/watch?v=YYYJTlOYdm0
			// 		http://youtu.be/YYYJTlOYdm0
			// 		https://vimeo.com/37708663
			// 		http://www.flickr.com/photos/riotking/2550468661
			// 		http://blip.tv/juliansmithtv/julian-smith-lottery-6362952
			// 		http://www.dailymotion.com/video/xull3h_monster-roll_shortfilms
			// 		http://www.ustream.tv/channel/3777978
			// 		http://www.ustream.tv/recorded/32219761
			// 		http://www.funnyordie.com/videos/5764ccf637/daft-punk-andrew-the-pizza-guy?playlist=featured_videos
			// 		http://www.hulu.com/watch/486928
			// 		http://revision3.com/destructoid/bl2-dlc-leak-tiny-tinas-assault-on-dragon-keep
			// 		http://www.viddler.com/v/bdce8c7
			// 		http://qik.com/video/38782012
			// 		http://home.wistia.com/medias/e4a27b971d
			// 		http://wordpress.tv/2013/10/26/chris-wilcoxson-how-to-build-your-first-widget/
	
			echo $oembed;

		} // End of embed codes

	} // End of $url & $service check
	
}

function bpphw_oembed_transient( $url, $service = '', $width = '', $height = '' ) {

	//require_once( ABSPATH . WPINC . '/class-oembed.php' );

	if ( empty( $url ) ) { return FALSE; }

	$key 	= md5( $url );
	//$oembed = get_transient( 'bpphw_' . $key );

	if ( $url ) {

		$oembed = wp_oembed_get( $url );

		if ( !$oembed ) { return FALSE; }

		//set_transient( 'bpphw_' . $key, $oembed, HOUR_IN_SECONDS );

	}

	return $oembed;

} // End of oembed_transient()


// Get friends widget output
function bpphw_get_friends_output( $user_id, $max_users, $avatar_size ) {

	if ( empty( $max_users ) ) {
		$max_users = 10;
	}
	if ( empty( $user_id ) ) {
		$user_id = bp_displayed_user_id();
	}
	// logged-in user isn't following anyone, so stop!
	if ( ! $friends = friends_get_friend_user_ids( $user_id ) ) {
		return false;
	}

	// show the users the logged-in user is following
	$had_filter = false;
	$args = array(
		'user_id'         => $user_id,
		'type'            => 'active',
		'include'         => $friends,
		'max'             => $max_users,
		'populate_extras' => 1,
	);
	
	if ( bp_has_members( $args ) ) {

?>

		<div class="avatar-block" style="display: flex; margin-left:auto;margin-right:auto;">
			<?php while ( bp_members() ) : bp_the_member(); ?>
				<div style="display:grid;margin-left:auto;margin-right:auto;text-align:center;" class="Avatar-grid">
					<div style="margin-left:5px; margin-right:5px;">
						<div style="margin-left:auto; margin-right:auto;" class="item-avatar">
							<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar(array( 'type' => $avatar_size )) ?></a>
						</div>
					</div>
					<div style="margin-left:5px; margin-right:5px;">
						<div  style="margin-left:auto; margin-right:auto;" class="item-username">
							<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_name() ?></a>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>

<?php
	}
}

// Get following widget output
function bpphw_get_follow_output( $user_id, $max_users, $avatar_size, $type = 'following' ) {

	if ( empty( $max_users ) ) {
		$max_users = 10;
	}
	if ( empty( $user_id ) ) {
		$user_id = bp_displayed_user_id();
	}
	// logged-in user isn't following anyone, so stop!
	if ( $type == 'following' ) {
		if ( ! $follow = bp_get_following_ids( array( 'user_id' => $user_id ) ) ) {
		return false;
		} 
	} else if ( $type == 'followers' ) {
			if ( ! $follow = bp_get_follower_ids( array( 'user_id' => $user_id ) ) ) {
			return false;
		}
	}

	// show the users the logged-in user is following
	$args = array(
		'include'       	=> $follow,
		'per_page'			=> $max_users,
		'max'             	=> $max_users,
		'populate_extras' 	=> false,
		'user_id'			=> bp_displayed_user_id()
	);
	if ( bp_has_members( $args ) ) {

?>

		<div class="avatar-block" style="display: flex;margin-left:auto;margin-right:auto;">
			<?php while ( bp_members() ) : bp_the_member(); ?>
			<div style="display:grid;margin-left:auto;margin-right:auto;text-align:center;" class="item-following">
				<div style="margin-left:5px; margin-right:5px;">
					<div class="item-avatar" style="margin-left:auto;margin-right:auto;">
						<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar(array('type' => $avatar_size)) ?></a>
					</div>
				</div>
				<div style="margin-left:5px; margin-right:5px;">
					<div class="item-username" style="margin-left:auto;margin-right:auto;">
						<a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_name() ?></a>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>

<?php
	}
}

function bpphw_get_groups_output( $user_id, $max_groups, $avatar_size, $per_page){

	if ( empty( $user_id ) ) {
		$user_id = bp_displayed_user_id();
	}

	if ( empty( $max_groups ) ) {
		$max_groups = 20;
	}
	
	$type = 'active';
	$limit = $max_groups;
	
	$group_args = array(
		'user_id'  => $user_id,
		'type'     => 'active',
		//'order'    => $instance['order'],
		'per_page' => $per_page,
		'max'      => $max_groups,
	);

	?>

	<?php if ( bp_has_groups( $group_args ) ) : ?>

		<div id="extended-groups-grid" style="display: flex;" class="item-list">

			<?php while ( bp_groups() ) : bp_the_group(); ?>
				<div style="display: grid;margin-right:auto;margin-left:auto;text-align:center;" <?php bp_group_class( array( 'bp-extended-user-groups-widget-item bp-extended-groups-clearfix' ) ); ?>>
					<div style="margin-left:5px; margin-right:5px;">
						<div style="margin-left:auto; margin-right: auto;" class="item-avatar">
							<a href="<?php bp_group_permalink() ?>"
							   title="<?php bp_group_name() ?>"><?php bp_group_avatar(array('type' => $avatar_size)) ?></a>
						</div>
					</div>
					<div style="margin-left:5px; margin-right:5px;">
						<div style="margin-left:auto; margin-right: auto;" class="item-title">
							<a href="<?php bp_group_permalink() ?>" title="<?php bp_group_name() ?>"><?php bp_group_name() ?></a>
						</div>
					</div>
					<div style="margin-left:5px; margin-right:5px;">
						<div style="margin-left:auto; margin-right: auto;" class="item-meta">
							<span class="activity">
								<?php
									if ( 'newest' == $type ) {
										/* translators: Displays the date the group was created */
										printf( esc_attr__( 'created %s', 'bp-extended-user-groups-widget' ), esc_attr(bp_get_group_date_created()) );
									} elseif ( 'active' == $type ) {
										/* translators: displays the groups last active date */
										printf( esc_attr__( 'active %s', 'bp-extended-user-groups-widget' ), esc_attr(bp_get_group_last_active()) );
									} elseif ( 'popular' == $type ) {
										bp_group_member_count();
									}
								?>
							</span>
						</div>
					</div>
				</div>

			<?php endwhile; ?>

		</div>

		<?php wp_nonce_field( 'groups_widget_groups_list', '_wpnonce-groups' ); ?>

		<input type="hidden" name="groups_widget_max" id="groups_widget_max" value="<?php echo esc_attr( $limit ); ?>"/>

	<?php else: ?>

		<div class="widget-error">

			<?php esc_attr_e( 'There are no groups to display.', 'bp-extended-user-groups-widget' ) ?>

		</div>

	<?php endif;
	
}

// Add Privacy functions
// Suggested content
function bpphw_add_privacy_policy_content() {
    if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
        return;
    }
 
    $content = sprintf( '<h3>' .
        esc_attr__( 'Profile Widgets Data', 'bp-profile-home-widgets') . '</h3><p>' .
		esc_attr__('When a user saves their text or video widgets, this may contain personal data so this data should be included in your privacy policy.', 'bp-profile-home-widgets') . '</p><p><b>' . esc_attr__('Suggested Text: ', 'bp-profile-home-widgets') . '</b>' . esc_attr__( 'When you add custom widgets to your profile, it\'s possible that this may include personal information. This site will store that information until you either clear the widgets or leave the site.', 'bp-profile-home-widgets') . '</p>'
    );
 
    wp_add_privacy_policy_content(
        'BP User Widgets Plugin',
        wp_kses_post( wpautop( $content, false ) )
    );
}
add_action( 'admin_init', 'bpphw_add_privacy_policy_content' );	


//Personal data exporter functions
function bpphw_exporter( $email_address, $page = 1 ) {

	$email_address = trim( $email_address );

	$user = get_user_by( 'email', $email_address );

	if ( ! $user ) {
		return array(
			'data' => array(),
			'done' => true,
		);
	}

	$widget_defaults = bpphw_get_defaults();
	
	$user_widgets = get_user_meta( $user->ID, 'bpphw_widget_data');
	$user_widgets = $user_widgets[0];
	$text_widgets = bpphw_get_widgets( 'text' );
	$video_widgets = bpphw_get_widgets( 'video' );
	
	
	if ( $user_widgets == $widget_defaults ) {
		return array(
			'data' => array(),
			'done' => true,
		);
	}

	$export_items = array();
	$index = 1;
 
	foreach ( (array) $user_widgets as $widget ) {
		if ( in_array( $widget['name'],$text_widgets ) || in_array( $widget['name'],$video_widgets ) ) {
			if ( $widget['visibility'] != 'none' ) {
				$item_id = $index;
				$index = $index + 1;
				$group_id = esc_attr__('BP Profile Home Widgets', 'bp-profile-home-widgets');
				$group_label = esc_attr__( 'User Widgets', 'bp-profile-home-widgets' );
				if ( in_array( $widget['name'],$text_widgets ) ) {
					$content = $widget['content'];
				}
				if ( in_array( $widget['name'],$video_widgets ) ) {
					$content = $widget['link'];
				}
				$data = array(
					array(
						'name' => esc_attr__( 'Widget Title', 'bp-profile-home-widgets' ),
						'value' => $widget['title']
					),
					array(
						'name' => esc_attr__( 'Widget Content', 'bp-profile-home-widgets' ),
						'value' => $content
					)
				);
		 
				$export_items[] = array(
					'group_id' => $group_id,
					'group_label' => $group_label,
					'item_id' => $item_id,
					'data' => $data,
				);
			}
		}
    }

	if ( empty( $export_items ) ) {
		return array(
			'data' => array(),
			'done' => true,
		);
	}

	return array(
		'data' => $export_items,
		'done' => true,
	);
}

function register_bpphw_exporter( $exporters ) {
	$exporters['bp-profile-home-widgets'] = array(
		'exporter_friendly_name' => esc_attr__( 'BP User Widgets Plugin' ),
		'callback' => 'bpphw_exporter',
	);
	return $exporters;
}
 
add_filter(	'wp_privacy_personal_data_exporters', 'register_bpphw_exporter', 10 );


// Personal data eraser functions
function bpphw_eraser( $email_address, $page = 1 ) {

	$email_address = trim( $email_address );

	$user = get_user_by( 'email', $email_address );

	if ( ! $user ) {
		return array(
			'items_retained' => false,
			'messages' => array(),
			'done' => true,
		);
	}

	$done = delete_user_meta( $user->ID, 'bpphw_widget_data');

	return array( 'items_removed' => $items_removed,
		'items_retained' => false,
		'messages' => array(),
		'done' => $done,
	);
}

function register_bpphw_eraser( $erasers ) {
	$erasers['bp-profile-home-widgets'] = array(
		'eraser_friendly_name' => esc_attr__( 'BP User Widgets Plugin', 'bp-profile-home-widgets' ),
		'callback'             => 'bpphw_eraser',
    );
	return $erasers;
}
 
add_filter( 'wp_privacy_personal_data_erasers', 'register_bpphw_eraser', 10 );

//Add Profile page widget areas
function bpphw_activate_legacy_widget_areas() {
	
	if ( bp_get_theme_package_id() == 'legacy' ) {
		
		if ( function_exists('register_sidebar') ) {

			register_sidebar(array(
				'name' 			=> esc_attr__('BuddyPress Profile Top', 'bp-profile-home-widgets'),
				'id' 			=> 'bpphw-profile-top-sidebar',
				'before_widget' => '<div class = "widgetizedArea">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h3>',
				'after_title' 	=> '</h3>',
			));
			
			register_sidebar(array(
				'name' 			=> esc_attr__('BuddyPress Profile Bottom', 'bp-profile-home-widgets'),
				'id' 			=> 'bpphw-profile-bottom-sidebar',
				'before_widget' => '<div class = "widgetizedArea">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h3>',
				'after_title' 	=> '</h3>',
			));
			
		}
		
	}
		
}

add_action( 'widgets_init', 'bpphw_activate_legacy_widget_areas' );

// Implement profile page widget area
function bpphw_add_widget_to_profile_bottom() {
	
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("bpphw-profile-bottom-sidebar") ) {
		echo '<div class="bp-profile-bottom-sidebar">';
			dynamic_sidebar('bpphw-profile-bottom-sidebar');
		echo '</div>';
	}
	
}

function bpphw_add_widget_to_profile_top() {
	
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("bpphw-profile-top-sidebar") ) {
		echo '<div class="bp-profile-top-sidebar">';
			dynamic_sidebar('bpphw-profile-top-sidebar');
		echo '</div>';
	}

}

add_action( 'bp_after_profile_content', 'bpphw_add_widget_to_profile_bottom' );
add_action( 'bp_before_profile_content', 'bpphw_add_widget_to_profile_top' );



