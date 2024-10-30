<?php
/**
 * BP Profile Home Widgets - Mention Me Post Form
 */

?>

<form action="<?php bp_activity_post_form_action(); ?>" method="post" id="whats-new-form" name="whats-new-form">

	<?php
	$user_data = get_userdata( bp_displayed_user_id() );
	$username = $user_data->user_login;

	?><p class="mentions-greeting"><?php 
		printf( esc_attr__( "Leave a comment for me, %s?", 'bp-profile-home-widgets' ), esc_attr(bp_get_user_firstname( bp_get_loggedin_user_fullname()) ) );
	?></p>

	<div id="mention-me-content">
		<div id="mention-me-textarea">
			<label for="whats-new" class="bp-screen-reader-text"><?php
				/* translators: accessibility text */
				esc_attr_e( 'Mention Me', 'bp-profile-home-widgets' );
			?></label>
			<textarea class="bp-suggestions" name="whats-new" id="whats-new" cols="50" rows="5"><?php printf( '@%s', esc_attr($username)) ?></textarea>
		</div>

		<div id="mention-me-options">
			<div id="whats-new-submit">
				<input type="submit" name="aw-whats-new-submit" id="aw-whats-new-submit" value="<?php esc_attr_e( 'Post Comment', 'bp-profile-home-widgets' ); ?>" />
			</div>

		</div><!-- #mention-me-options -->
	</div><!-- #mention-me-content -->

	<?php wp_nonce_field( 'post_update', '_wpnonce_post_update' ); ?>

</form><!-- #Mention-Me-form -->
