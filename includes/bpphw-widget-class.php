<?php
/*
BP Profile Home Widgets - Widget Functions

Text Domain: bp-profile-home-widgets

*/

global $bpphw_video_width;

class BP_Profile_Home_Widgets extends WP_Widget {



	/**
	 * Sets up the widgets name etc
	 */
	 
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'bp_profile_home_widgets',
			'description' => sanitize_text_field(__( 'Adds user sortable and selectable widgets to BP Nouveau Home page', 'bp-profile-home-widgets' ) ),
		);
		parent::__construct( 'bp_profile_home_widgets', sanitize_text_field( esc_attr__( 'BP Profile Home Widgets', 'bp-profile-home-widgets' ) ), $widget_ops );
		global $bpphw_video_width;
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		$logged_in_user_id = bp_loggedin_user_id();
		$displayed_user_id = bp_displayed_user_id();
		$title_text = sanitize_text_field( esc_attr__( 'Title:', 'bp-profile-home-widgets' ) );
		$video_widgets = bpphw_get_widgets( 'video' );
		$text_widgets = bpphw_get_widgets( 'text' );
		$follow_widgets = bpphw_get_widgets( 'follow' );
		$wordpress_widgets = bpphw_get_widgets( 'wordpress' );
		$buddypress_widgets = bpphw_get_widgets( 'buddypress' );
		$displayed = 0;
		$presets = get_option( 'bpphw_presets' );
		
		if ( bp_is_user_profile() || bp_is_user_activity() || bp_is_user() ) {
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] && $logged_in_user_id == $displayed_user_id ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}
			

			$widget_data = bpphw_get_widget_data( $displayed_user_id );
			
			if ( !$widget_data && isset( $presets ) && is_array( $presets) ) $widget_data = $presets;

			echo '<ul id="sortable-hw" style="margin-left:0px;">';
			
			For ( $n = 1; $n <= 12; $n++ ) {
				foreach ( $widget_data as $widget ) {
					
					if ( $widget['position'] == $n ) {
						if ( ( in_array( $widget['name'], $wordpress_widgets ) && ! $instance['disable_wordpress'] ) || ( in_array( $widget['name'], $video_widgets ) && ! $instance['disable_videos'] ) ||  ( in_array( $widget['name'], $text_widgets ) && ! $instance['disable_text'] ) || ( in_array( $widget['name'], $follow_widgets ) && ! $instance['disable_follow'] && function_exists( 'bp_follow_start_following' ) ) || ( $widget['name'] == 'groups' && ! $instance['disable_buddypress'] && bp_is_active( 'groups' ) ) || ( $widget['name'] == 'friends' && ! $instance['disable_buddypress'] && bp_is_active( 'friends' ) ) || ( ( $widget['name'] == 'activity' || $widget['name'] == 'mentions' || $widget['name'] == 'mention_me' ) && ! $instance['disable_buddypress'] && bp_is_active( 'activity' ) ) ) {
							
							// Create widget structure
							echo '<li id="bpphw_' . $widget['name'] . '" data-name="' . $widget['name'] . '" data-position="' . $widget['position'] . '" data-index="' . $widget['index'] . '" style="display: ' . $widget['visibility'] . '; text-align: left;" class="bpphw_li_class "><span class="ui-icon"></span>';
							echo '<hr>';
							echo '<h3 style="text-align: center;" class="ui-icon-arrowthick-2-n-s" id="bpphw_desc_' . $widget['name'] . '">' . $widget['title'] . '</h3>';
							
							// Display widget content
							// Video Widget
							if ( in_array( $widget['name'], $video_widgets ) ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" >';
								if( $widget['link'] != '' ) {
									echo '<div class="bpphw-video-wrapper">';
									bpphw_get_video_content( $displayed_user_id, $widget['link'], $widget['name'], $instance['width'] );
									echo '</div>';
									$displayed = 1;
								}
								echo '</div>';
							}
							// Text Widget
							if ( in_array( $widget['name'], $text_widgets ) ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-text-widget" data-name="' . $widget['name'] . '">';
								if( $widget['content'] != '' ) {
									echo do_shortcode( $widget['content'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Followed Widget
							if ( $widget['name'] == 'followed' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-followed-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_follow_output( $displayed_user_id, $widget['max_users'], $widget['avatar_size'], 'followers' );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Following Widget
							if ( $widget['name'] == 'following' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-following-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_follow_output( $displayed_user_id, $widget['max_users']. $widget['avatar_size'], 'following' );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Friends Widget
							if ( $widget['name'] == 'friends' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-friends-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_friends_output( $displayed_user_id, $widget['max_users'], $widget['avatar_size'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Groups Widget
							if ( $widget['name'] == 'groups' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-groups-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_groups_output( $displayed_user_id, $widget['max_groups'], $widget['avatar_size'], 10 );
									$displayed = 1;
								}
								echo '</div>';
							}
							
							// WordPress Widget
							if ( $widget['name'] == 'posts' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-posts-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_posts_output( $displayed_user_id, $widget['max_posts'], $widget['img_size'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Activity Widget
							if ( $widget['name'] == 'activity' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-' . $widget['name'] . '-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_activity_output( $displayed_user_id, $widget['max_posts'], $widget['avatar_size'] );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Mentions Widget
							if ( $widget['name'] == 'mentions' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-' . $widget['name'] . '-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_activity_output( $displayed_user_id, $widget['max_posts'], $widget['avatar_size'], 'mentions' );
									$displayed = 1;
								}
								echo '</div>';
							}
							// Mention Me Widget
							if ( $widget['name'] == 'mention_me' ) {
								echo '<div id="bpphw_display_' . $widget['name'] . '" class="bpphw-' . $widget['name'] . '-widget" data-name="' . $widget['name'] . '">';
								if( $widget['visibility'] != 'none' ) {
									bpphw_get_mention_me_output();
									$displayed = 1;
								}
								echo '</div>';
							}
							
							// Set up widget edit fields
							if ( $displayed_user_id == $logged_in_user_id ) {
								//Video Widgets
								if ( in_array( $widget['name'], $video_widgets ) ) {
									
									if ( ! empty($widget['link']) ) {
										
										echo '<small><input type="button" value="' . sanitize_text_field( esc_attr__( 'Change Video', 'bp-profile-home-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpphw_add_' . $widget['name'] . '" style="display: none;" class="bpphw_add">
										
										<input type="button" value="' . sanitize_text_field( esc_attr__( 'Clear Video', 'bp-profile-home-widgets' ) ) . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" id="bpphw_clear_' . $widget['name'] . '" style="display: none;" class="bpphw_clear_video_button"></small>';
									
									} else {
										
										echo '<small><input type="button" value="' . sanitize_text_field( esc_attr__( 'Add a Video', 'bp-profile-home-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpphw_add_' . $widget['name'] . '" style="display: none;" class="bpphw_add"></small>';
									
									}
								}
								// Text Widgets
								if ( in_array( $widget['name'], $text_widgets ) ) {
									if ( ! empty($widget['content']) ) {
										echo '<small><input type="button" value="' . sanitize_text_field( esc_attr__( 'Change Text', 'bp-profile-home-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpphw_add_' . $widget['name'] . '" style="display: none;" class="bpphw_add">

										<input type="button" value="' . sanitize_text_field( esc_attr__( 'Clear Text', 'bp-profile-home-widgets' ) ) . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" id="bpphw_clear_' . $widget['name'] . '" style="display: none;" class="bpphw_clear_text_button"></small>';
									
									} else {
										
										echo '<small>
											<input type="button" value="' . sanitize_text_field( esc_attr__( 'Add Text', 'bp-profile-home-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpphw_add_' . $widget['name'] . '" style="display: none;" class="bpphw_add">
											</small>';
									}
								}
								// Follow, WordPress and BP Widgets
								if ( in_array( $widget['name'], $wordpress_widgets ) || in_array( $widget['name'], $follow_widgets ) || in_array( $widget['name'], $buddypress_widgets ) ) {
									
									if ( $widget['visibility'] != 'none' ) {
										
										echo '<small><input type="button" value="' . sanitize_text_field( esc_attr__( 'Change', 'bp-profile-home-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpphw_add_' . $widget['name'] . '" style="display: none;" class="bpphw_add">
										
										<input type="button" value="' . sanitize_text_field( esc_attr__( 'Hide Widget', 'bp-profile-home-widgets' ) ) . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" id="bpphw_clear_' . $widget['name'] . '" style="display: none;" class="bpphw_clear_' . $widget['name'] . '_button"></small>';
									
									} else {
										
										echo '<small><input type="button" value="' . sanitize_text_field( esc_attr__( 'Add Widget', 'bp-profile-home-widgets' ) ) . '" data-name="' . $widget['name'] . '" id="bpphw_add_' . $widget['name'] . '" style="display: none;" class="bpphw_add"></small>';
									
									}
								}
								// Generic setting up edit form
								echo '<div id="bpphw_form_' . $widget['name'] . '" style="display: none;">
								<p style="text-align: left;">' . $title_text . '</p>
								<input type="text" placeholder="' . $title_text . '" id="bpphw_title_' . $widget['name'] . '" value="' . $widget['title'] . '"></br>';
								// Widget type specific fields
								// Video Widget
								if ( in_array( $widget['name'], $video_widgets ) ) {
									echo '<input type="text" placeholder="' . sanitize_text_field( esc_attr__( 'Paste Video URL here', 'bp-profile-home-widgets' ) ) . '" id="bpphw_url_' . $widget['name'] . '" ';
									if ( ! empty( $widget['link'] ) ) {
										echo 'value="' . $widget['link'] . '"';
									}
									echo '>
									<span style="display: none;" for="bpphw_autoplay_' . $widget['name'] . '" ><input type="checkbox" value="' . $widget['autoplay'] . '" style="display: none;" id="bpphw_autoplay_' . $widget['name'] . '">' . sanitize_text_field(__( 'Autoplay', 'bp-profile-home-widgets' ) ) . '</span>
									<input type="button" value="' . sanitize_text_field( esc_attr__( 'Submit', 'bp-profile-home-widgets' ) ) . '" class="bpphw_submit_video" id="bpphw_submit_' . $widget['name'] . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" >
									</div>';
								}
								// Text Widget
								if ( in_array( $widget['name'], $text_widgets ) ) {
									echo '<div id="bpphw_content_input_' . $widget['name'] . '" >';

									$content = html_entity_decode($widget['content'] );
									$editor = 'bpphw_content_' . $widget['name'];
									$settings = array(
										'textarea_rows' => 4,
										'media_buttons' => true,
										'teeny'			=> false,
									);

									wp_editor( $content, $editor, $settings);

									
									echo '</div>
										<input type="button" value="' . sanitize_text_field( esc_attr__( 'Submit', 'bp-profile-home-widgets' ) ) . '" class="bpphw_submit_text" id="bpphw_submit_' . $widget['name'] . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" >
									</div>';
								}
								// WordPress, Follow and BP Widgets
								if ( in_array( $widget['name'], $wordpress_widgets ) || in_array( $widget['name'], $follow_widgets ) || in_array( $widget['name'], $buddypress_widgets ) ) {
									// Follow and Friends widgets
									if ( in_array( $widget['name'], $follow_widgets ) || $widget['name'] == 'friends' ) {
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( esc_attr__( 'Max users', 'bp-profile-home-widgets' ) ) . '" id="bpphw_max_users_' . $widget['name'] . '" ';
										if ( ! empty( $widget['max_users'] ) ) {
											echo 'value="' . $widget['max_users'] . '"';
										}
										echo '><small><span style="display; inline-block; text-align: left;">' . sanitize_text_field( esc_attr__( ' Max Users to show', 'bp-profile-home-widgets' ) ) . '</span></small></br>';
										echo '
										<label for="bpphw_'.$widget['name'].'_avatar_size">' . esc_attr__( 'Avatar Size:', 'bp-profile-home-widgets') . '</label>
										<select id="bpphw_'.$widget['name'].'_avatar_size" name="bpphw_'.$widget['name'].'_avatar_size" style="width: 25%;">
											<option value="full" ';
											if ( $widget['avatar_size'] == 'full' ) { echo 'selected = "selected"'; }
											echo '>'. esc_attr__('Full', 'bp-profile-home-widgets' ) . '</option>
											<option value="thumb" ';
											if ( $widget['avatar_size'] == 'thumb' ) { echo 'selected = "selected"'; }
											echo '>' . esc_attr__('Thumb', 'bp-profile-home-widgets' ) . '</option>
										  </select></br>';
									}
									if ( $widget['name'] == 'groups' ) {
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( esc_attr__( 'Max groups', 'bp-profile-home-widgets' ) ) . '" id="bpphw_max_groups_' . $widget['name'] . '" ';
										if ( ! empty( $widget['max_groups'] ) ) {
											echo 'value="' . $widget['max_groups'] . '"';
										}
										echo '><small><span style="display; inline-block;">' . sanitize_text_field( esc_attr__( ' Max Groups to show', 'bp-profile-home-widgets' ) ) . '</span></small></br>';
										echo '
										<label for="bpphw_'.$widget['name'].'_avatar_size">' . esc_attr__( 'Avatar Size:', 'bp-profile-home-widgets') . '</label>
										<select id="bpphw_'.$widget['name'].'_avatar_size" name="bpphw_'.$widget['name'].'_avatar_size" style="width: 25%;">
											<option value="full" ';
											if ( $widget['avatar_size'] == 'full' ) { echo 'selected = "selected"'; }
											echo '>'. esc_attr__('Full', 'bp-profile-home-widgets' ) . '</option>
											<option value="thumb" ';
											if ( $widget['avatar_size'] == 'thumb' ) { echo 'selected = "selected"'; }
											echo '>' . esc_attr__('Thumb', 'bp-profile-home-widgets' ) . '</option>
										  </select></br>';
									}
									if ( $widget['name'] == 'posts' ) {
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( esc_attr__( 'Max posts', 'bp-profile-home-widgets' ) ) . '" id="bpphw_max_posts_' . $widget['name'] . '" ';
										if ( ! empty( $widget['max_posts'] ) ) {
											echo 'value="' . $widget['max_posts'] . '"';
										}
										echo '><small><span style="display; inline-block;">' . sanitize_text_field( esc_attr__( ' Max Posts to show', 'bp-profile-home-widgets' ) ) . '</span></small></br>';
										echo '
										<label for="bpphw_'.$widget['name'].'_image_size">' . esc_attr__( 'Featured image Size:', 'bp-profile-home-widgets') . '</label>
										<select id="bpphw_img_size_' . $widget['name'] . '" name="bpphw_'.$widget['name'].'_image_size" style="width: 25%;">
											<option value="full" ';
											if ( $widget['img_size'] == 'full' ) { echo 'selected = "selected"'; }
											echo '>'. esc_attr__('Full', 'bp-profile-home-widgets' ) . '</option>
											<option value="large" ';
											if ( $widget['img_size'] == 'large' ) { echo 'selected = "selected"'; }
											echo '>'. esc_attr__('Large', 'bp-profile-home-widgets' ) . '</option>
											<option value="medium" ';
											if ( $widget['img_size'] == 'medium' ) { echo 'selected = "selected"'; }
											echo '>'. esc_attr__('Medium', 'bp-profile-home-widgets' ) . '</option>
											<option value="thumb" ';
											if ( $widget['img_size'] == 'thumbnail' ) { echo 'selected = "selected"'; }
											echo '>' . esc_attr__('Thumbnail', 'bp-profile-home-widgets' ) . '</option>
										  </select></br>';
									}
									if ( $widget['name'] == 'activity' || $widget['name'] == 'mentions' ) {
										echo '<input type="text" style="width: 25%; display: inline-block;" placeholder="' . sanitize_text_field( esc_attr__( 'Max Items', 'bp-profile-home-widgets' ) ) . '" id="bpphw_max_posts_' . $widget['name'] . '" ';
										if ( ! empty( $widget['max_posts'] ) ) {
											echo 'value="' . $widget['max_posts'] . '"';
										}
										echo '><small><span style="display; inline-block;">' . sanitize_text_field( esc_attr__( ' Max Items to show', 'bp-profile-home-widgets' ) ) . '</span></small></br>';
										echo '
										<label for="bpphw_'.$widget['name'].'_avatar_size">' . esc_attr__( 'Avatar Size:', 'bp-profile-home-widgets') . '</label>
										<select id="bpphw_'.$widget['name'].'_avatar_size" name="bpphw_'.$widget['name'].'_avatar_size" style="width: 25%;">
											<option value="full" ';
											if ( $widget['avatar_size'] == 'full' ) { echo 'selected = "selected"'; }
											echo '>'. esc_attr__('Full', 'bp-profile-home-widgets' ) . '</option>
											<option value="thumb" ';
											if ( $widget['avatar_size'] == 'thumb' ) { echo 'selected = "selected"'; }
											echo '>' . esc_attr__('Thumb', 'bp-profile-home-widgets' ) . '</option>
										  </select></br>';
									}
									if ( $widget['name'] == 'mention_me' ) {
										echo '<select id="bpphw_mention_me_enable" style="width: 35%; display: inline-block;">
											<option value="display"';
											if ( $widget['visibility'] != 'none' ) {
												echo ' selected="selected"';
											}
											echo '>Display Mention Me comment box</option>
											<option value="hide"';
											if ( $widget['visibility'] == 'none' ) {
												echo ' selected="selected"';
											}
											echo '>Hide Mention Me comment box</option>
										</select>';
									}
									echo '<input type="button" value="' . sanitize_text_field( esc_attr__( 'Submit', 'bp-profile-home-widgets' ) ) . '" class="bpphw_submit_follow" id="bpphw_submit_' . $widget['name'] . '" data-user="' . $displayed_user_id . '" data-name="' . $widget['name'] . '" >
									</div>';
								}
								
								// Feedback field
								echo '<p id="bpphw_feedback_' . $widget['name'] . '" style="display: none;"></p>';
							
							}
							echo '</li>';
						}
					}
				}
			}
			echo '</ul>';
			if ( bp_displayed_user_id() == bp_loggedin_user_id() ) {
				echo '<small><input type="button" value="';

				if ( $displayed == 1 ) { 
					
					echo sanitize_text_field(esc_attr__( 'Update Widgets', 'bp-profile-home-widgets' ) );
				
				} else {
					
					echo sanitize_text_field(esc_attr__( 'Add a Widget', 'bp-profile-home-widgets' ) );
				
				}
				
				echo '" id="bpphw-add-widget" class="bpphw-add-widget-button"></small>';

				if ( current_user_can( 'manage_options' ) ) {
					
					echo '<small><input type="button" value="';

					if ( isset( $presets ) && $presets != false ) { 
						
						echo sanitize_text_field(esc_attr__( 'Clear Preset', 'bp-profile-home-widgets' ) ) . '" name="clear';
					
					} else {
						
						echo sanitize_text_field(esc_attr__( 'Save as Preset', 'bp-profile-home-widgets' ) ) . '" name="save';
					
					}
					echo '" id="bpphw-update-preset" class="bpphw-update-presets-button"></small>';
				}
				
				echo '<small><input type="button" data-user="' . bp_displayed_user_id() . '" value="' . sanitize_text_field(__( 'Clear All', 'bp-profile-home-widgets' ) ) . '" id="bpphw-reset-widget" class="bpphw-reset-widget-button" style="display: none;"></small>
				
				<div id="bpphw-widget-form" style="display: none;">
					<small><p id="bpphw_info">' . sanitize_text_field( esc_attr__( 'Select an empty widget and input the required info' , 'bp-profile-home-widgets' ) ) . '</p></small>
				</div>';
			
			}
			echo $args['after_widget'];
		}


	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Home Widgets', 'bp-profile-home-widgets' );
		$width = ! empty( $instance['width'] ) ? $instance['width'] : 300;
		$disable_videos = ! empty( $instance['disable_videos'] ) ? $instance['disable_videos'] : 0;
		$disable_text = ! empty( $instance['disable_text'] ) ? $instance['disable_text'] : 0;
		$disable_wordpress = ! empty( $instance['disable_wordpress'] ) ? $instance['disable_wordpress'] : 0;
		$disable_follow = ! empty( $instance['disable_follow'] ) ? $instance['disable_follow'] : 0;
		$disable_buddypress = ! empty( $instance['disable_buddypress'] ) ? $instance['disable_buddypress'] : 0;
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'bp-profile-home-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_attr_e( 'Width (px):', 'bp-profile-home-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'disable_videos' ) ); ?>"><?php esc_attr_e( 'Disable Video/Audio Widgets:', 'bp-profile-home-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'disable_videos' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_videos' ) ); ?>" type="checkbox" value="0" <?php if ( $disable_videos ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'disable_text' ) ); ?>"><?php esc_attr_e( 'Disable Text Widgets:', 'bp-profile-home-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'disable_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_text' ) ); ?>" type="checkbox" value="<?php echo esc_attr( $disable_text ); ?>" <?php if ( $disable_text ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'disable_wordpress' ) ); ?>"><?php esc_attr_e( 'Disable WordPress Widgets:', 'bp-profile-home-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'disable_wordpress' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_wordpress' ) ); ?>" type="checkbox" value="<?php echo esc_attr( $disable_wordpress ); ?>" <?php if ( $disable_wordpress ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'disable_follow' ) ); ?>"><?php esc_attr_e( 'Disable Follow Widgets:', 'bp-profile-home-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'disable_follow' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_follow' ) ); ?>" type="checkbox" value="<?php echo esc_attr( $disable_follow ); ?>" <?php if ( $disable_follow ): echo 'checked="checked"'; endif; ?>>
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'disable_buddypress' ) ); ?>"><?php esc_attr_e( 'Disable BuddyPress (My Friends, My Groups, My Activity, My Mentions )  Widgets:', 'bp-profile-home-widgets' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'disable_buddypress' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_buddypress' ) ); ?>" type="checkbox" value="<?php echo esc_attr( $disable_buddypress ); ?>" <?php if ( $disable_buddypress ): echo 'checked="checked"'; endif; ?>>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? esc_attr( $new_instance['title'] ) : '';
		$instance['width'] = ( ! empty( $new_instance['width'] ) ) ? esc_attr( $new_instance['width'] ) : 300;
		$bpphw_video_width = update_option('bpphw_widget_options' , $instance['width'] );
		$instance['disable_videos'] = ( isset( $new_instance['disable_videos'] ) ? 1 : 0 );
		$instance['disable_text'] = ( isset( $new_instance['disable_text'] ) ? 1 : 0 );
		$instance['disable_wordpress'] = ( isset( $new_instance['disable_wordpress'] ) ? 1 : 0 );
		$instance['disable_follow'] = ( isset( $new_instance['disable_follow'] ) ? 1 : 0 );
		$instance['disable_buddypress'] = ( isset( $new_instance['disable_buddypress'] ) ? 1 : 0 );

		return $instance;
	}
	

}