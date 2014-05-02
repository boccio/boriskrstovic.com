
<?php 
#
# Determine where we are and what to display:
#
if(is_home() or is_front_page()){
	$header_style 			= bl_utilities::get_option('bl_header_style');
	$header_html  			= bl_utilities::get_option('bl_header_html');
	$header_background 		= bl_utilities::get_option('bl_header_background');
	$header_video_webm 		= bl_utilities::get_option('bl_header_video_webm');
	$header_video_mp4 		= bl_utilities::get_option('bl_header_video_mp4');
	$header_video_png 		= bl_utilities::get_option('bl_header_video_png');
	$header_logo	 		= bl_utilities::get_option('bl_header_logo');
}else if(is_single()){
	$header_style 			= bl_utilities::get_option('bl_header_style_posts');
	$header_html  			= bl_utilities::get_option('bl_header_html_posts');
	$header_background 		= bl_utilities::get_option('bl_header_background_posts');
	$header_video_webm 		= bl_utilities::get_option('bl_header_video_webm_posts');
	$header_video_mp4 		= bl_utilities::get_option('bl_header_video_mp4_posts');
	$header_video_png 		= bl_utilities::get_option('bl_header_video_png_posts');
	$header_logo	 		= bl_utilities::get_option('bl_header_logo_posts');
}else{
	$header_style 			= bl_utilities::get_option('bl_header_style_pages');
	$header_html  			= bl_utilities::get_option('bl_header_html_pages');
	$header_background 		= bl_utilities::get_option('bl_header_background_pages');
	$header_video_webm 		= bl_utilities::get_option('bl_header_video_webm_pages');
	$header_video_mp4 		= bl_utilities::get_option('bl_header_video_mp4_pages');
	$header_video_png 		= bl_utilities::get_option('bl_header_video_png_pages');
	$header_logo	 		= bl_utilities::get_option('bl_header_logo_pages');

	// show the title in the header area
	if( is_page() and get_post_meta( get_the_ID(), 'blu_title_in_page_header', true ) == 'on' ){
		$header_style 		= 'title';
	}
}
$header_area_height = get_post_meta( get_the_ID(), 'blu_custom_header_area_height', true);
$header_area_styling = "";
if($header_area_height and $header_area_height != ''){
	$header_area_styling .= "height: ".$header_area_height."px; ";
}
// echo !empty() ? "height:" . get_post_meta( get_the_ID(), 'blu_custom_header_area_height', true ) . 'px' : ''; ?>

<div class="header-area" style="<?php echo $header_area_styling; ?>"><?php
	if($header_style == 'authors'){ ?>
		<ul class="header-authors unstyled"><?php		
			// If it's a single post then just display the author
			// else display all users that are selected
			if(is_single()){ ?>

				<li>
					<img class="author-image" src="<?php echo blu_get_avatar_url( get_avatar( get_the_author_meta( 'ID' ) , 'medium' )); ?>">
					<h2 class="author-name"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo blu_boldsplit(get_the_author_meta( 'display_name' )); ?></a></h2> <?php 
					if(of_get_option('author_job_'.get_the_author_meta( 'ID' ))){ ?>
						<small class="author-job"><?php echo of_get_option('author_job_'.get_the_author_meta( 'ID' )); ?></small><?php
					} ?>
					<div class="author-social"><?php
						if(of_get_option('author_facebook_'.get_the_author_meta( 'ID' ))){ ?>
							<a href="<?php echo of_get_option('author_facebook_'.get_the_author_meta( 'ID' )); ?>"><i class="fa fa-facebook"></i></a> <?php
						}
						if(of_get_option('author_twitter_'.get_the_author_meta( 'ID' ))){ ?>
							<a href="<?php echo of_get_option('author_twitter_'.get_the_author_meta( 'ID' )); ?>"><i class="fa fa-twitter"></i></a> <?php
						}
						if(of_get_option('author_google_'.get_the_author_meta( 'ID' ))){ ?>
							<a href="<?php echo of_get_option('author_google_'.get_the_author_meta( 'ID' )); ?>"><i class="fa fa-google-plus"></i></a> <?php
						}
						if(of_get_option('author_instagram_'.get_the_author_meta( 'ID' ))){ ?>
							<a href="<?php echo of_get_option('author_instagram_'.get_the_author_meta( 'ID' )); ?>"><i class="fa fa-instagram"></i></a> <?php
						} ?>
					</div>
				</li><?php

			}else{
				$users = get_users( array('who' => 'authors') );
				foreach($users as $user){ 
					if(of_get_option('author_front_'.$user->ID)){ ?>
						<li>
							<img class="author-image" src="<?php echo blu_get_avatar_url( get_avatar( $user->ID , 'medium' )); ?>">
							<h2 class="author-name"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo blu_boldsplit($user->display_name); ?></a></h2> 
							<small class="author-job"><?php echo of_get_option('author_job_'.$user->ID); ?></small> 
							<div class="author-social"><?php
								if(of_get_option('author_facebook_'.$user->ID)){ ?>
									<a href="<?php echo of_get_option('author_facebook_'.$user->ID); ?>"><i class="fa fa-facebook"></i></a> <?php
								}
								if(of_get_option('author_twitter_'.$user->ID)){ ?>
									<a href="<?php echo of_get_option('author_twitter_'.$user->ID); ?>"><i class="fa fa-twitter"></i></a> <?php
								}
								if(of_get_option('author_google_'.$user->ID)){ ?>
									<a href="<?php echo of_get_option('author_google_'.$user->ID); ?>"><i class="fa fa-google-plus"></i></a> <?php
								}
								if(of_get_option('author_instagram_'.$user->ID)){ ?>
									<a href="<?php echo of_get_option('author_instagram_'.$user->ID); ?>"><i class="fa fa-instagram"></i></a> <?php
								} ?>
							</div>
						</li><?php
					}
				}
			} ?>
		</ul><?php
	}elseif($header_style == 'description'){ ?>
		<div class="header-description"><h2><?php bloginfo( 'description' ); ?></h2></div><?php
	}elseif($header_style == 'logo_description'){ ?>
		<div class="header-logo"></div>
		<div class="header-description"><img src="<?php echo $header_logo; ?>"><br><h2><?php bloginfo( 'description' ); ?></h2></div><?php
	}elseif($header_style == 'html'){ ?>
		<div class="header-html"><?php echo apply_filters('shortcode_filter', do_shortcode($header_html)); ?></div><?php
	}elseif($header_style == 'title'){ ?>
		<div class="header-description">
			<div class="header-title">
				<h1 class="blu_thin"><?php echo blu_boldsplit( get_the_title() ); ?></h1><?php
				if($post_subtitle = get_post_meta( get_the_ID(), 'bluth_page_subtitle', 'off' )){ ?>
					<small class="meta-sub-title">
						<?php echo $post_subtitle; ?>
					</small><?php
				} ?>
			</div>
		</div><?php
	} ?>
</div><?php

if($header_background == 'video'){ ?>

	<div class="header-video" style="background-image:url('<?php echo $header_video_png; ?>');">
		<video autoplay loop id="bgvid">
			<source src="<?php echo $header_video_webm; ?>" type="video/webm">
			<source src="<?php echo $header_video_mp4; ?>" type="video/mp4">
			<img src="<?php echo $header_video_png; ?>" title="Your browser does not support the video tag" style="width: 100%; height: auto;">
		</video>
	</div><?php
}