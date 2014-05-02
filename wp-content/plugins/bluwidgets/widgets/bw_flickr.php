<?php
class bw_flickr extends WP_Widget
{
  	function bw_flickr(){
    	$widget_ops = array('classname' => 'bw_flickr bw_slider', 'description' => __( 'Displays recent Flickr photos in a widget. Recommended for the sidebar.', 'bwidgets') );
    	$this->WP_Widget('bw_flickr', 'Bluwidgets: Flickr', $widget_ops);
  	}	
	function form( $instance ){

		//Set up some default widget settings.
		$defaults = array( 'title' => '', 'num' => '9', 'user_id' => '', 'username' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'bwidgets' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php echo __( 'Flickr ID:', 'bwidgets' ); ?></label>
			<small>You can find your ID <a href="http://idgettr.com/" target="_blank">here</a></small>
			<input type="text" id="<?php echo $this->get_field_id( 'user_id' ); ?>" name="<?php echo $this->get_field_name( 'user_id' ); ?>" value="<?php echo $instance['user_id']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php echo __( 'Flickr Username:', 'bwidgets' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'num' ); ?>"><?php echo __( 'Photos Count:', 'bwidgets' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'num' ); ?>" id="<?php echo $this->get_field_id( 'num' ); ?>" class="widefat"> <?php
				$options = array( '1', '2', '3', '4', '5', '6', '7', '8', '9' );
				foreach ( $options as $option ) { ?>
					<option value="<?php echo $option; ?>" id="<?php echo $option; ?>" <?php echo $instance['num'] == $option ? 'selected' : ''; ?>>
						<?php echo $option; ?>
					</option><?php
				} ?>
			</select>
		</p>

	  	<p>
	    	<label for="<?php echo $this->get_field_id('use_theme_styling'); ?>">Use theme styling (only available for bluthemes)</label><br>
			<select style="width:100%" id="<?php echo $this->get_field_id('use_theme_styling'); ?>" name="<?php echo $this->get_field_name('use_theme_styling'); ?>">
		  		<option value="false" <?php echo ($instance['use_theme_styling'] == 'false') ? 'selected=""' : ''; ?>>No</option> 
		  		<option value="true" <?php echo ($instance['use_theme_styling'] == 'true') ? 'selected=""' : ''; ?>>Yes</option> 
			</select>
	  	</p><?php

		echo $html;
	}
	function widget( $args, $instance ){
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters( 'widget_title', $instance['title'] );
		$user_id = $instance['user_id'];
		$username = $instance['username'];
		$num = $instance['num'];

		$params = array(
			'api_key'  => '07a5b8a2ef5251509df92b7735679bd4',
			'method'   => 'flickr.photos.search',
			'user_id'  => $user_id,
			'per_page' => $num,
			'format'   => 'php_serial',
			'extras'   => 'description, license, date_upload, date_taken, owner_name, icon_server, original_format, last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_sq, url_t, url_s, url_q, url_m, url_n, url_z, url_c, url_l, url_o',
		);
		$encoded_params = array();

		echo $before_widget;

		// Display the widget title
		echo !empty($instance['title']) ? $before_title.$title . $after_title : '' ?>
  		<div class="widget-body" <?php echo $instance['use_theme_styling'] == 'true' ? 'theme-styling' : ''; ?> > <?php

	   		#
	   		# CACHING
	   		#
	   		
			// If there isn't a cached version available then make one, otherwise fetch the information from it
	    	if(($cache = get_transient('bw_flickr')) === false){

		    	// Get Photos
		    	foreach ( $params as $k => $v ) { $encoded_params[] = urlencode( $k ) . '=' . urlencode( $v ); }

				# call the API and decode the response
				$url = "http://api.flickr.com/services/rest/?" . implode( '&', $encoded_params );
				$photos = @wp_remote_retrieve_body( @wp_remote_get( $url ));
				$stat = unserialize($photos);

				// If there's an error message, then delete the cache so we don't cache an error message
				// else if there isn't an error, then set it up
				if($stat['stat'] === 'fail'){
					delete_transient( 'bw_flickr' ); 
				}else{ 
			        set_transient( 'bw_flickr', array( 'photos' => $photos ), 1800);
				}

	    	}else{
				$photos = $cache['photos'];
	   		}  

	   		$photos = unserialize($photos); ?>

  			<div class="flickr-header">
  				<a class="flickr-username" href="http://www.flickr.com/photos/<?php echo $username; ?>" target="_blank"><?php echo $username; ?></a>
  				<div class="flickr-logo" style="background-image: url('<?php echo plugins_url('bluwidgets/assets/flickr-assets.png'); ?>');"></div>
  			</div>
			<div class="swiper-images-container">
				<div class="swiper-container swiper-container-flickr">
				    <a class="arrow-left" style="background-image: url('<?php echo plugins_url('bluwidgets/assets/instagram-assets-2.png'); ?>');"></a>
			    	<a class="arrow-right" style="background-image: url('<?php echo plugins_url('bluwidgets/assets/instagram-assets-2.png'); ?>');"></a>
					<div class="swiper-wrapper"><?php

						# display the photo title (or an error if it failed)
						if ( $photos['stat'] == 'ok' ) {
							$isfirst = true;
							foreach ( $photos['photos']['photo'] as $photo ) { ?>
									<div class="swiper-slide"> 
										<div class="swiper-image" style="background-image: url('http://farm<?php echo $photo['farm'] ?>.staticflickr.com/<?php echo $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret']; ?>.jpg');"></div>
									</div><?php
								}
							}

						else { ?>
							<div class="swiper-slide">  
								<span style="padding: 50px 0; color: red;">Call Failed</span><br>
								<span style="padding: 50px 0; color: red;">(<?php echo $photos['message']; ?>)</span>
							</div><?php
						} ?>

					</div> <!-- swiper-wrapper -->
				</div> <!-- swiper-container -->
			</div>
			<div class="flickr-interactions"> <?php 
						
				$slide_class = 'active';
				foreach ( $photos['photos']['photo'] as $photo ) { ?>
				<?php /*var_dump($photos);*/ ?>
					<div class="flickr-slide <?php echo $slide_class; ?>">
						<a href="http://www.flickr.com/photos/<?php echo $username.'/'.$photo['id']; ?>" target="_blank"><?php echo $photo['title']; ?></a>
						<div class="star-star-icon" style="background-image: url('<?php echo plugins_url('bluwidgets/assets/flickr-assets.png'); ?>');"></div>
					</div> <?php 
					$slide_class = 'bl_hide';
				} ?>
			</div>
		</div>

		<?php echo $after_widget;
	}
	function update( $new_instance, $old_instance ){
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user_id'] = $new_instance['user_id'];
		$instance['username'] = $new_instance['username'];
		$instance['num'] = strip_tags( $new_instance['num'] );
		$instance['use_theme_styling']      = strip_tags($new_instance['use_theme_styling']);
		
		return $instance;
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("bw_flickr");') ); 
