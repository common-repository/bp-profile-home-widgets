/*
* @package bp-profile-home-widgets
*/



// Setup variables for button images
jQuery(document).ready(function($){

	//Make videos Responsive
	// Find all iframes
	var $iframes = jQuery( ".bpphw-video-wrapper iframe" );

	// Find &#x26; save the aspect ratio for all iframes
	$iframes.each(function () {
	  jQuery( this ).data( "ratio", this.height / this.width )
		// Remove the hardcoded width &#x26; height attributes
		.removeAttr( "width" )
		.removeAttr( "height" );
	});

	// Resize the iframes when the window is resized
	jQuery( window ).resize( function () {
	  $iframes.each( function() {
		// Get the parent container&#x27;s width
		var width = $( this ).parent().width();
		jQuery( this ).width( width )
		  .height( width * $( this ).data( "ratio" ) );
	  });
	// Resize to fix all iframes on page load.
	}).resize();

	// fix for responsive images in text editor 
	$('#bpphw_display_text_1 img').attr('width', '100%').attr('height', '');
	$('#bpphw_display_text_2 img').attr('width', '100%').attr('height', '');

	// Set up the sortable widgets
	$( function() {
		$( "#sortable-hw" ).sortable({
			update: function( event, ui ) {
				$(this).children().each(function (index) {
					if ($(this).attr('data-position') != (index+1)) {
						$(this).attr('data-position', (index+1)).addClass('updated');
					}
				});
				var positions = [];
				$('.updated').each(function() {
					positions.push([$(this).attr('data-name'),$(this).attr('data-position')]);
					$(this).removeClass('updated');
				});
				$.ajax({
					url : ajax_object.ajaxurl,
					type : 'post',
					data : {
						positions : positions,
						security : ajax_object.check_nonce,
						action : "bpphw_moveable_widgets"
					},
					success : function(data) {
						if ( data == 1 ) {
						
						} else {
						
						}
						
					},
					error : function(data){
						console.log(data);
					}
				});
				
			}
		});
		$( "#sortable-hw" ).disableSelection();
	} );
	
	// Open up the edit widgets dialogue
	function openWidgets(e){

		var resetButton = document.getElementById( 'bpphw-reset-widget' );
		var widgetForm = document.getElementById( 'bpphw-widget-form' );

		var widgets = [ 'text_1', 'text_2', 'video_1', 'video_2', 'posts', 'following', 'followed', 'friends', 'groups', 'activity', 'mentions', 'mention_me' ]	;
		
		var video1 = document.getElementById( 'bpphw_video_1' );
		var video1Button = document.getElementById( 'bpphw_add_video_1' );
		var video1ClearButton = document.getElementById( 'bpphw_clear_video_1' );

		var video2 = document.getElementById( 'bpphw_video_2' );
		var video2Button = document.getElementById( 'bpphw_add_video_2' );
		var video2ClearButton = document.getElementById( 'bpphw_clear_video_2' );

		var text1 = document.getElementById( 'bpphw_text_1' );
		var text1Button = document.getElementById( 'bpphw_add_text_1' );
		var text1ClearButton = document.getElementById( 'bpphw_clear_text_1' );

		var text2 = document.getElementById( 'bpphw_text_2' );
		var text2Button = document.getElementById( 'bpphw_add_text_2' );
		var text2ClearButton = document.getElementById( 'bpphw_clear_text_2' );

		var following = document.getElementById( 'bpphw_following' );
		var followingButton = document.getElementById( 'bpphw_add_following' );
		var followingClearButton = document.getElementById( 'bpphw_clear_following' );

		var followed = document.getElementById( 'bpphw_followed' );
		var followedButton = document.getElementById( 'bpphw_add_followed' );
		var followedClearButton = document.getElementById( 'bpphw_clear_followed' );

		var friends = document.getElementById( 'bpphw_friends' );
		var friendsButton = document.getElementById( 'bpphw_add_friends' );
		var friendsClearButton = document.getElementById( 'bpphw_clear_friends' );

		var groups = document.getElementById( 'bpphw_groups' );
		var groupsButton = document.getElementById( 'bpphw_add_groups' );
		var groupsClearButton = document.getElementById( 'bpphw_clear_groups' );

		var posts = document.getElementById( 'bpphw_posts' );
		var postsButton = document.getElementById( 'bpphw_add_posts' );
		var postsClearButton = document.getElementById( 'bpphw_clear_posts' );

		var activity = document.getElementById( 'bpphw_activity' );
		var activityButton = document.getElementById( 'bpphw_add_activity' );
		var activityClearButton = document.getElementById( 'bpphw_clear_activity' );

		var mentions = document.getElementById( 'bpphw_mentions' );
		var mentionsButton = document.getElementById( 'bpphw_add_mentions' );
		var mentionsClearButton = document.getElementById( 'bpphw_clear_mentions' );

		var mentionMe = document.getElementById( 'bpphw_mention_me' );
		var mentionMeButton = document.getElementById( 'bpphw_add_mention_me' );
		var mentionMeClearButton = document.getElementById( 'bpphw_clear_mention_me' );

		resetButton.style.display = 'block';
		this.style.display = 'none';
		
		if ( video1 != null ) {
			video1.style.display = 'block';
			video1Button.style.display = 'block';
		}
		if ( video1ClearButton != null ) {
			video1ClearButton.style.display = 'block';
		}
		if ( video2 != null ) {
			video2.style.display = 'block';
			video2Button.style.display = 'block';
		}
		if ( video2ClearButton != null ) {
			video2ClearButton.style.display = 'block';
		}
		
		if ( text1 != null ) {
			text1.style.display = 'block';
			text2.style.display = 'block';
			text1Button.style.display = 'block';
			text2Button.style.display = 'block';
		}
		if ( text1ClearButton != null ) {
			text1ClearButton.style.display = 'block';
		}
		if ( text2ClearButton != null ) {
			text2ClearButton.style.display = 'block';
		}
		
		if ( video1 != null ) {
			video1.style.display = 'block';
			video1Button.style.display = 'block';
		}
		if ( video1ClearButton != null ) {
			video1ClearButton.style.display = 'block';
		}
		if ( video2 != null ) {
			video2.style.display = 'block';
			video2Button.style.display = 'block';
		}
		if ( video2ClearButton != null ) {
			video2ClearButton.style.display = 'block';
		}

		if ( following != null ) {
			following.style.display = 'block';
			followed.style.display = 'block';
			followingButton.style.display = 'block';
			followedButton.style.display = 'block';
		}
		if ( followingClearButton != null ) {
			followingClearButton.style.display = 'block';
		}
		if ( followedClearButton != null ) {
			followedClearButton.style.display = 'block';
		}

		if ( friends != null ) {
			friends.style.display = 'block';
			friendsButton.style.display = 'block';
		}
		if ( friendsClearButton != null ) {
			friendsClearButton.style.display = 'block';
		}

		if ( groups != null ) {
			groups.style.display = 'block';
			groupsButton.style.display = 'block';
		}
		if ( groupsClearButton != null ) {
			groupsClearButton.style.display = 'block';
		}

		if ( posts != null ) {
			posts.style.display = 'block';
			postsButton.style.display = 'block';
		}
		if ( postsClearButton != null ) {
			postsClearButton.style.display = 'block';
		}

		if ( activity != null ) {
			activity.style.display = 'block';
			activityButton.style.display = 'block';
		}
		if ( activityClearButton != null ) {
			activityClearButton.style.display = 'block';
		}

		if ( mentions != null ) {
			mentions.style.display = 'block';
			mentionsButton.style.display = 'block';
		}
		if ( mentionsClearButton != null ) {
			mentionsClearButton.style.display = 'block';
		}

		if ( mentionMe != null ) {
			mentionMe.style.display = 'block';
			mentionMeButton.style.display = 'block';
		}
		if ( mentionMeClearButton != null ) {
			mentionMeClearButton.style.display = 'block';
		}

		widgetForm.style.display = 'block';
	}

	$('.bpphw-add-widget-button').off().on('click', openWidgets);
	
	// function to reset the user widget data to defaults
	function resetWidget(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var feedback = document.getElementById( 'bpphw_info' );
		
		feedback.style.display = 'block';
		feedback.innerHTML = bpphw_translate.resetWidget;
		
		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				userId : userId,
				security : ajax_object.check_nonce,
				action : "bpphw_reset_widget"
			},
			success : function(data) {
				if ( data == 1 ) {
					feedback.innerHTML = bpphw_translate.successRefresh;
				} else {
					feedback.innerHTML = bpphw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpphw_translate.tryAgain;
			}
		});
			
	}

	$('.bpphw-reset-widget-button').off().on('click', resetWidget);

	// Generic Widget Functions
	
	// Open add/edit form
	function openInputForm(e){

		var clicked = e.target;
		var name = clicked.getAttribute( 'data-name' );
		var inputForm = document.getElementById( 'bpphw_form_' + name );
		var ClearButton = document.getElementById( 'bpphw_clear_' + name );
		var title = document.getElementById( 'bpphw_desc_' + name );

		if ( inputForm.style.display == 'none' ) {
			inputForm.style.display = 'block';
//			ClearButton.style.display = 'block'
			clicked.value = bpphw_translate.cancel;
		} else {
			inputForm.style.display = 'none';
			if ( title.innerHTML == name ) {
				clicked.value = bpphw_translate.add;
			} else { 
				clicked.value = bpphw_translate.change;
			}
		}
		

	}


	$('.bpphw_add').off().on('click', openInputForm);

	// Clear widget function
	function clearWidget(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var feedback = document.getElementById( 'bpphw_feedback_' + name );
		var displayContent = document.getElementById('bpphw_display_' + name );
		var ClearButton = document.getElementById( 'bpphw_clear_' + name );
		var addButton = document.getElementById( 'bpphw_add_' + name );
		var title = document.getElementById( 'bpphw_desc_' + name );
		var inputForm = document.getElementById( 'bpphw_form_' + name );
		feedback.style.display = 'block';
		feedback.innerHTML = bpphw_translate.deleting;

		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				userId : userId,
				name : name,
				security : ajax_object.check_nonce,
				action : "bpphw_clear_widget"
			},
			success : function(data) {
				if ( data == 1 ) {
					feedback.innerHTML = bpphw_translate.success;
					displayContent.style.display = 'none';
					ClearButton.style.display = 'none'
					addButton.value = bpphw_translate.add;
					title.innerHTML = name;
					inputForm.style.display = 'none';
				} else {
					feedback.innerHTML = bpphw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpphw_translate.tryAgain;
			}
		});
			
	}

	$('.bpphw_clear_video_button').off().on('click', clearWidget);
	$('.bpphw_clear_text_button').off().on('click', clearWidget);
	$('.bpphw_clear_friends_button').off().on('click', clearWidget);
	$('.bpphw_clear_groups_button').off().on('click', clearWidget);
	$('.bpphw_clear_following_button').off().on('click', clearWidget);
	$('.bpphw_clear_followed_button').off().on('click', clearWidget);
	$('.bpphw_clear_posts_button').off().on('click', clearWidget);
	$('.bpphw_clear_activity_button').off().on('click', clearWidget);
	$('.bpphw_clear_mentions_button').off().on('click', clearWidget);
	$('.bpphw_clear_mentionMe_button').off().on('click', clearWidget);

	// Video Widget Functions

	//Add video URL
	function addVideoUrl(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var videoForm = document.getElementById( 'bpphw_form_' + name );
		var videoInputUrl = document.getElementById( 'bpphw_url_' + name );
		var videoTitle = document.getElementById( 'bpphw_title_' + name );
		var title = document.getElementById( 'bpphw_desc_' + name );
		var displayContent = document.getElementById('bpphw_display_' + name );
		var feedback = document.getElementById( 'bpphw_feedback_' + name );
		var autoplay = document.getElementById( 'bpphw_autoplay_' + name ).value;
		var addButton = document.getElementById( 'bpphw_add_' + name );
		feedback.style.display = 'block';

		if ( videoInputUrl.value != '' ) {

			feedback.innerHTML = bpphw_translate.addingVideo;
			
			$.ajax({
				url : ajax_object.ajaxurl,
				type : 'post',
				data : {
					userId : userId,
					name : name,
					videoURL : videoInputUrl.value,
					autoplay : autoplay,
					title : videoTitle.value,
					security : ajax_object.check_nonce,
					action : "bpphw_add_video"
				},
				success : function(data) {
					if ( data ) {
						videoForm.style.display = 'none';
						displayContent.style.display = 'block';
						displayContent.innerHTML = data;
						feedback.innerHTML = bpphw_translate.success;
						addButton.value = bpphw_translate.change;
						title.innerHTML = videoTitle.value;
						} else {
						feedback.innerHTML = bpphw_translate.tryAgain;
					}
					
				},
				error : function(data){
					feedback.innerHTML = bpphw_translate.tryAgain;
				}
			});
			
		} else {
			
			feedback.innerHTML = bpphw_translate.enterVideo;
			
		}
	}

	$('.bpphw_submit_video').off().on('click', addVideoUrl);
	

	// Text Widget Functions
	
	//Add text input
	function addText(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var textForm = document.getElementById( 'bpphw_form_' + name );
		var textContent =  tinyMCE.get('bpphw_content_' + name);
		var textTitle = document.getElementById( 'bpphw_title_' + name );
		var title = document.getElementById( 'bpphw_desc_' + name );
		var textInput = document.getElementById( 'bpphw_content_input_' + name );
		var displayContent = document.getElementById('bpphw_display_' + name );
		var feedback = document.getElementById( 'bpphw_feedback_' + name );
		var addButton = document.getElementById( 'bpphw_add_' + name );

		if ( null === textContent ) {
			textContent = document.getElementById( 'bpphw_content_' + name ).value;
		} else {
			textContent =  textContent.getContent();
		}
		
		feedback.style.display = 'block';

		if ( textContent.value != '' ) {
			feedback.innerHTML = bpphw_translate.addingText;
			$.ajax({
				url : ajax_object.ajaxurl,
				type : 'post',
				data : {
					userId : userId,
					name : name,
					content : textContent,
					title : textTitle.value,
					security : ajax_object.check_nonce,
					action : "bpphw_add_text"
				},
				success : function(data) {
					if ( data ) {
						textForm.style.display = 'none';
//						textInput.style.display = 'none';
						if ( displayContent != null ) {
							displayContent.innerHTML = data;
							addButton.value = bpphw_translate.change;
							title.innerHTML = textTitle.value;
							$('#bpphw_display_' + name + ' img').attr('width', '100%').attr('height', '');
							displayContent.style.display = 'block';
						}
						feedback.innerHTML = bpphw_translate.success;
					} else {
						feedback.innerHTML = bpphw_translate.tryAgain;
					}
					
				},
				error : function(data){
					feedback.innerHTML = bpphw_translate.tryAgain;
				}
			});
			
		} else {
			
			feedback.innerHTML = bpphw_translate.enterText;
			
		}
	}

	$('.bpphw_submit_text').off().on('click', addText);

	//Add follow and BuddyPress input
	function addFollow(e){

		var clicked = e.target;
		var userId = clicked.getAttribute( 'data-user');
		var name = clicked.getAttribute( 'data-name' );
		var followForm = document.getElementById( 'bpphw_form_' + name );
		var followUsers =  document.getElementById( 'bpphw_max_users_' + name );
		var followGroups =  document.getElementById( 'bpphw_max_groups_' + name );
		var followPosts =  document.getElementById( 'bpphw_max_posts_' + name );
		var followImgSize =  document.getElementById( 'bpphw_img_size_' + name );
		var followAvatarSize =  document.getElementById( 'bpphw_' + name + '_avatar_size' );
		var followTitle = document.getElementById( 'bpphw_title_' + name );
		var title = document.getElementById( 'bpphw_desc_' + name );
		var displayContent = document.getElementById('bpphw_display_' + name );
		var feedback = document.getElementById( 'bpphw_feedback_' + name );
		var addButton = document.getElementById( 'bpphw_add_' + name );
		var avatarSize = 'full';
		var imgSize = 150;
		var max = 10
		if ( followUsers != null ) {
			if ( !isNaN( followUsers.value ) ) {
				max = followUsers.value;
			}
		} 
		if ( followGroups != null )  {
			if ( !isNaN( followGroups.value ) ) {
				max = followGroups.value;
			}
		} 
		if ( followPosts != null ) {
			max = followPosts.value;
			if ( followImgSize != null ) {
				if ( !isNaN( followImgSize.value ) ) {
					imgSize = followImgSize.value;
				}
			}
		}
		if ( followAvatarSize == null )  {
			if ( followAvatarSize.value == 'full' || followAvatarSize.value == 'thumb' ) {
				avatarSize = followAvatarSize.value;
			}
		} 		
		feedback.style.display = 'block';
		switch( name ) {
			
			case 'friends' :
				feedback.innerHTML = bpphw_translate.addingFriends;
				break;
			case 'groups' :
				feedback.innerHTML = bpphw_translate.addingGroups;
				break;
			case 'followed' :
				feedback.innerHTML = bpphw_translate.addingFollowers;
				break;
			case 'following' :
				feedback.innerHTML = bpphw_translate.addingFollowing;
				break;
			case 'posts' :
				feedback.innerHTML = bpphw_translate.addingPosts;
				break;
			case 'activity' :
				feedback.innerHTML = bpphw_translate.addingActivity;
				break;
			case 'mentions' :
				feedback.innerHTML = bpphw_translate.addingMentions;
				break;
			case 'mention_me' :
				var mentionEnable = document.getElementById('bpphw_mention_me_enable');
				if ( mentionEnable.value == 'display' ) {
					feedback.innerHTML = bpphw_translate.addingMentionMe;
				} else {
					return;
				}
				break;
		}
		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				userId : userId,
				name : name,
				max : max,
				imgSize : imgSize,
				avatarSize : avatarSize,
				title : followTitle.value,
				security : ajax_object.check_nonce,
				action : "bpphw_add_follow"
			},
			success : function(data) {
				if ( data ) {
					followForm.style.display = 'none';
					// if ( name == 'groups' ) {
						// followGroups.style.display = 'none';
					// } else {
						// followUsers.style.display = 'none';
					// }
					if ( displayContent != null ) {
						displayContent.innerHTML = data;
						addButton.value = bpphw_translate.change;
						title.innerHTML = followTitle.value;
						displayContent.style.display = 'block';
					}
					feedback.innerHTML = bpphw_translate.success;
				} else {
					feedback.innerHTML = bpphw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpphw_translate.tryAgain;
			}
		});
		
	}

	$( '.bpphw_submit_follow' ).off().on( 'click', addFollow );

	// Save/clear presets
	function updatePresets(e){

		var clicked = e.target;
		var feedback = document.getElementById( 'bpphw_info' );
		var feedbackForm = document.getElementById( 'bpphw-widget-form' );
		feedbackForm.style.display = 'block';

		if ( clicked.name === 'clear' ) {
			feedback.innerHTML = bpphw_translate.clearingPreset;
			update = 'clear'
		} else {
			feedback.innerHTML = bpphw_translate.savingPreset;
			update = 'save';
		}
		$.ajax({
			url : ajax_object.ajaxurl,
			type : 'post',
			data : {
				update : update,
				security : ajax_object.check_nonce,
				action : "bpphw_update_presets"
			},
			success : function(data) {
				if ( data == 1 ) {
					feedback.innerHTML = bpphw_translate.success;
					if ( clicked.name === 'clear' ) {
						clicked.value = bpphw_translate.savePreset;
						clicked.name = 'save';
					} else {
						clicked.value = bpphw_translate.clearPreset;
						clicked.name = 'clear';
					}
				} else {
					feedback.innerHTML = bpphw_translate.tryAgain;
				}
				
			},
			error : function(data){
				feedback.innerHTML = bpphw_translate.tryAgain;
			}
		});
		
	}

	$( '#bpphw-update-preset' ).off().on( 'click', updatePresets );
});