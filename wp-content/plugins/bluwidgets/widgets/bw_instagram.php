<?php
class bw_instagram extends WP_Widget
{
	function bw_instagram(){
		$widget_ops = array('classname' => 'bw_instagram bw_slider', 'description' => __( 'Displays recent instagram images in a widget. Recommended for the sidebar.', 'bwidgets') );
	    $this->WP_Widget('bw_instagram', 'Bluwidgets: Instagram', $widget_ops);
	}
	function form( $instance ){

	    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
	    
	    $title        = !empty($instance['title']) ? $instance['title'] : '';
	    $access_token = !empty($instance['access_token']) ? $instance['access_token'] : '';
	    $user_id      = !empty($instance['user_id']) ? $instance['user_id'] : '';  ?>
	  	<p>
	    	<label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br>
	    	<input type="text" style="width:100%" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>">
	  	</p>
		<p>
	    	<label for="<?php echo $this->get_field_id('access_token'); ?>">Access token</label><br>
	    	<input type="text" style="width:100%" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" value="<?php echo $access_token; ?>">
	  	</p>
		<p>
	    	<label for="<?php echo $this->get_field_id('user_id'); ?>">User id</label><br>
	    	<input type="text" style="width:100%" id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" value="<?php echo $user_id; ?>">
	  	</p>
	  	<p>
	    	<label for="<?php echo $this->get_field_id('show_icon'); ?>">Show Instagram icon instead of title</label><br>
			<select style="width:100%" id="<?php echo $this->get_field_id('show_icon'); ?>" name="<?php echo $this->get_field_name('show_icon'); ?>">
		  		<option value="true" <?php echo ($instance['show_icon'] == 'true') ? 'selected=""' : ''; ?>>Yes</option> 
		  		<option value="false" <?php echo ($instance['show_icon'] == 'false') ? 'selected=""' : ''; ?>>No</option> 
			</select>
	  	</p>
	  	<p>
	    	<label for="<?php echo $this->get_field_id('use_theme_styling'); ?>">Use theme styling (only available for bluthemes)</label><br>
			<select style="width:100%" id="<?php echo $this->get_field_id('use_theme_styling'); ?>" name="<?php echo $this->get_field_name('use_theme_styling'); ?>">
		  		<option value="false" <?php echo ($instance['use_theme_styling'] == 'false') ? 'selected=""' : ''; ?>>No</option> 
		  		<option value="true" <?php echo ($instance['use_theme_styling'] == 'true') ? 'selected=""' : ''; ?>>Yes</option> 
			</select>
	  	</p>
	  	<p>
	  		<div class="instruction-box" style="padding: 10px; background-color: #D7F7DF;">
		  		<a href="#" class="btn blu_empty_instagram_cache">Manually empty the cache</a>
		  		<small style="display:block;">Press this to empty the cache (if the widget isn't fetching the newest image then you should use this)</small>
	  		</div>
	  	</p>
	  	<hr>
	  	<div class="instruction-box" style="padding: 10px; background-color: #D7F7DF;">
		  	<strong>Instructions</strong>
		  	<p>You need to authenticate yourself to our instagram app to get an access token to retrieve your images and display them on your page.</p>
		  	<ol>
		    	<li>Attain your access token and user id <a href="https://api.instagram.com/oauth/authorize/?client_id=e802ca96dd27470f9ef0271bc9f0e6a3&redirect_uri=http://www.bluth.is/&response_type=code" target="_blank">by clicking here</a></li>
		    	<li>Copy the access token and user id</li>
		    	<li>Paste them in the input box below</li>
		  	</ol>
		  	<p>Not recommended in the footer area because of sizing issues.</p>
	  	</div> <?php
	}
  	function widget( $args, $instance ){

    	extract($args, EXTR_SKIP);

		echo $before_widget;

		$title = apply_filters('widget_title', $instance['title'], $instance['show_icon'] ); 
		/* show instagram logo or show the native menu */
		if($instance['show_icon'] == 'false'){
			echo $before_title . $title . $after_title; 
		}else{ ?>
			<div class="widget-header-instagram <?php echo $instance['use_theme_styling'] == 'true' ? 'theme-styling' : ''; ?> ">
				<div class="instagram-logo" style="background-image:url('<?php echo plugins_url('bluwidgets/assets/instagram-assets.png'); ?>');"></div>
			</div><?php
		} ?>

    	<div class="widget-body <?php echo $instance['use_theme_styling'] == 'true' ? 'theme-styling' : ''; ?> "><?php

			if(empty($instance['user_id'])){
				echo '<div class="alert alert-error" style="margin:0"><h4>Instagram user id not set</h4>';
				echo '<p>Please add your user id in the input field for the widget</p></div>';  			
			}
			elseif(empty($instance['access_token'])){
				echo '<div class="alert alert-error" style="margin:0"><h4>Instagram access token not set</h4>';
				echo '<p>Please add your access token in the input field for the widget</p></div>';     			
			}
			else{


		   		#
		   		# CACHING
		   		#
		   		
				// If there isn't a cached version available then make one, otherwise fetch the information from it
		    	if(($cache = get_transient('bw_instagram')) === false){
			    	
			    	// Get Photos
			    	$posts_data = @wp_remote_retrieve_body(@wp_remote_get("https://api.instagram.com/v1/users/".$instance['user_id']."/media/recent/?access_token=".$instance['access_token']));
				    try{ $posts = json_decode($posts_data); }catch(Exception $ex){ $posts = false; }

				    // Get Author Data (followers, photos, following)
			    	$user_data = @wp_remote_retrieve_body(@wp_remote_get("https://api.instagram.com/v1/users/".$instance['user_id']."?access_token=".$instance['access_token']));
					try{ $user = json_decode($user_data); }catch(Exception $ex){ $user = false; }

					// If there's no error message, then set the cache up, if there is an error, then delete it.
					if($user and $posts and !isset($posts->meta->error_message) and !isset($user->meta->error_message)){
				        set_transient( 'bw_instagram', array('posts' => $posts_data, 'user' => $user_data), 1800);
					}else{ delete_transient( 'bw_instagram' ); }

		    	}else{
					$posts 	= json_decode($cache['posts']);
					$user 	= json_decode($cache['user']);
		   		} 


		   		#
		   		# ERROR HANDLING
		   		#
		   		
				$interactions = array();
				if(!$user and !$posts){
					echo '<div class="alert alert-error" style="margin:0"><h4>Could not load Instagram photos at this time</h4></div>';
				}
				elseif(isset($posts->meta->error_message)){
					echo '<div class="alert alert-error" style="margin:0"><h4>Error</h4>';
					echo '<p>'.$posts->meta->error_message.'</p></div>';     
				}
				else if(isset($user->meta->error_message)){
					echo '<div class="alert alert-error" style="margin:0"><h4>Error</h4>';
					echo '<p>'.$user->meta->error_message.'</p></div>';
				}
				else{ 

			   		#
			   		# THE WIDGET
			   		#
					?>
					<ul class="instagram-header">	
						<li>
							<p><?php echo $user->data->counts->followed_by ?></p>
							<small class="text-muted"><?php _e('followers', 'bwidgets'); ?></small>
						</li>	
						<li>
							<p><?php echo $user->data->counts->follows ?></p>
							<small class="text-muted"><?php _e('following', 'bwidgets'); ?></small>
						</li>	
						<li>
							<p><?php echo $user->data->counts->media ?></p>
							<small class="text-muted"><?php _e('photos', 'bwidgets'); ?></small>
						</li>
					</ul>	
					<div class="swiper-images-container">
						<div class="swiper-container swiper-container-instagram">
						    <a class="arrow-left" style="background-image: url('<?php echo plugins_url('bluwidgets/assets/instagram-assets-2.png'); ?>');"></a>
			    			<a class="arrow-right" style="background-image: url('<?php echo plugins_url('bluwidgets/assets/instagram-assets-2.png'); ?>');"></a>							
							<div class="swiper-wrapper"><?php 
								foreach ($posts->data as $post) { ?>
									<div class="swiper-slide" data-first-liker="<?php echo ($post->likes->count > 1) ? $post->likes->data[0]->username : ''; ?>" data-likes-count="<?php echo $post->likes->count; ?>"> 
										<div class="swiper-image" style="background-image: url('<?php echo $post->images->low_resolution->url ?>')"></div>
										<a class="insta-link" href="<?php echo $post->link ?>#" target="_blank"></a>
									</div><?php 
								} ?>
							</div> <!-- swiper-wrapper -->
						</div> <!-- swiper-container -->
					</div>
					<div class="instagram-interactions"> <?php 
						
						$slide_class = 'active';
						foreach ($posts->data as $post) { ?>
							<div class="instagram-slide <?php echo $slide_class; ?>">
								<div class="instagram-heart-icon" style="background-image: url('<?php echo plugins_url('bluwidgets/assets/instagram-assets-2.png'); ?>');"></div>
								<div class="instagram-likes"><?php
									if($post->likes->count > 1){
										echo '<a href="http://www.instagram.com/'.$post->likes->data[0]->username.'/#" target="_blank"><strong>'.$post->likes->data[0]->username . '</strong></a> and <strong>' . ($post->likes->count-1) .'</strong> others like this'; 
									}else{
										echo $post->comments->count .' liked'; 
									} ?>
								</div>
								<div class="instagram-comments"></div>
							</div> <?php 
							$slide_class = 'bl_hide';
						} ?>
					</div>
					<?php
				}
			} ?>
      	</div><?php

		echo $after_widget;
  	}
  	function update( $new_instance, $old_instance ){
  		delete_transient( 'bw_instagram' );
    	$instance = $old_instance;
    	$instance['title']          = strip_tags($new_instance['title']);
    	$instance['access_token']   = strip_tags($new_instance['access_token']);
    	$instance['user_id']        = strip_tags($new_instance['user_id']);
    	$instance['show_icon']      = strip_tags($new_instance['show_icon']);
    	$instance['use_theme_styling']      = strip_tags($new_instance['use_theme_styling']);
    	// $instance['show_caption']   = strip_tags($new_instance['show_caption']);
    	return $instance;
  	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("bw_instagram");') ); 