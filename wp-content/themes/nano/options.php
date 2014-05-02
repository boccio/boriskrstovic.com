<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'bluth_admin'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {


	$background_mode = array(
		'image' => __('Image', 'bluth_admin'),
		'pattern' => __('Pattern', 'bluth_admin'),
		'color' => __('Solid Color', 'bluth_admin')
	);


	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/assets/img/';

	$options = array();


	$options[] = array(
		'name' => '<i class="icon-gauge-1"></i> ' . __('Theme Options', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Customizer', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => '',
				'desc' => '',
				'id' => 'cust_not',
				'type' => 'customizer_notification');

		$options[] = array(
			'name' => __('Featured Images', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Featured Images Cropped Height', 'bluth_admin'),
				'desc' => __('The height of the cropped images in pixels (Default 500) <strong>NOTE:</strong> It is recommended you <a href="http://wordpress.org/plugins/force-regenerate-thumbnails/" target="_blank">regenerate your thumbnails</a> if you change this like you should have done when installing the theme.', 'bluth_admin'),
				'id' => 'featured_image_cropped_height',
				'std' => '500',
				'type' => 'text'
				);

			$options[] = array(
				'name' => __('Featured Images Cropped Width', 'bluth_admin'),
				'desc' => __('The width of the cropped images in pixels (Default 980) <strong>NOTE:</strong> It is recommended you <a href="http://wordpress.org/plugins/force-regenerate-thumbnails/" target="_blank">regenerate your thumbnails</a> if you change this like you should have done when installing the theme.', 'bluth_admin'),
				'id' => 'featured_image_cropped_width',
				'std' => '840',
				'type' => 'text'
				);

		$options[] = array(
			'name' => __('Various Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Google Analytics', 'bluth_admin'),
				'desc' => __('Add your Google Analytics tracking code here. Google Analytics is a free web analytics service more info here: <a href="http://www.google.com/analytics/">Google Analytics</a>', 'bluth_admin'),
				'id' => 'google_analytics',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Featured Tag', 'bluth_admin'),
				'desc' => __('The tag that the featured posts widget will use to fetch posts', 'bluth_admin'),
				'id' => 'featured_tag',
				'std' => 'featured',
				'type' => 'text');

			$options[] = array(
				'name' => __('Disable All SEO Options', 'bluth_admin'),
				'desc' => __('Check this to give an SEO plugin control of meta description, title and open graph tags.', 'bluth_admin'),
				'id' => 'seo_plugin',
				'std' => '0',
				'type' => 'checkbox');


	$options[] = array(
		'name' => '<i class="icon-users-2"></i> ' . __('Users', 'bluth_admin'),
		'type' => 'heading');

	$users = get_users( array('who' => 'authors') );
	foreach($users as $user){
		
		$options[] = array(
			'name' => __( 'User: '.$user->user_nicename, 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Author Cover for '.$user->user_nicename, 'bluth_admin'),
				'desc' => __('Upload a cover for the author box', 'bluth_admin'),
				'id' => 'author_box_image_'.$user->ID,
				'type' => 'upload');

			$options[] = array(
				'name' => __('Author Box Avatar', 'bluth_admin'),
				'desc' => __('Upload a custom avatar for the author box (will use gravatar if nothing is set) (120x120)', 'bluth_admin'),
				'id' => 'author_box_avatar_'.$user->ID,
				'type' => 'upload');
		
			$options[] = array(
				'name' => __('Show information on front page', 'bluth_admin'),
				'desc' => __('Check this if you want to display information about this author on the front page.', 'bluth_admin'),
				'id' => 'author_front_'.$user->ID,
				'std' => '1',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Job', 'bluth_admin'),
				'desc' => __('What does this particular user do (in short)', 'bluth_admin'),
				'id' => 'author_job_'.$user->ID,
				'std' => 'Visionary',
				'type' => 'text');

			$options[] = array(
				'name' => __('Facebook', 'bluth_admin'),
				'desc' => __('Facebook URL for this user', 'bluth_admin'),
				'id' => 'author_facebook_'.$user->ID,
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Twitter', 'bluth_admin'),
				'desc' => __('Twitter URL for this user', 'bluth_admin'),
				'id' => 'author_twitter_'.$user->ID,
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Google+', 'bluth_admin'),
				'desc' => __('Google+ URL for this user', 'bluth_admin'),
				'id' => 'author_google_'.$user->ID,
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Instagram', 'bluth_admin'),
				'desc' => __('Instagram URL for this user', 'bluth_admin'),
				'id' => 'author_instagram_'.$user->ID,
				'std' => '',
				'type' => 'text');
	}

	$options[] = array(
		'name' => '<i class="icon-star-1"></i> ' . __('Advertising', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Google Ads', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Google Publisher ID', 'bluth_admin'),
				'desc' => __('Found in the top right corner of your <a href="https://www.google.com/adsense/" target="_blank">adsense account</a>.', 'bluth_admin'),
				'id' => 'google_publisher_id',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Google Ad unit ID', 'bluth_admin'),
				'desc' => __('Found in your Ad Units area under <strong>ID</strong> <a href="https://www.google.com/adsense/app#myads-springboard" target="_blank">here</a>.', 'bluth_admin'),
				'id' => 'google_ad_unit_id',
				'std' => '',
				'type' => 'text');

		$options[] = array(
			'name' => __('Advertising Areas', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Ad spot #1 - Above the header.', 'bluth_admin'),
				'desc' => __('Select what kind of ad you want added above the top menu.', 'bluth_admin'),
				'id' => 'ad_header_mode',
				'std' => 'none',
				'type' => 'radio',
				'options' => array(
					'none' => __('None', 'bluth_admin'),
					'html' => __('Shortcode or HTML code like Adsense', 'bluth_admin'),
					'image' => __('Image with a link', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add Shortcode or HTML code here', 'bluth_admin'),
				'desc' => __('Insert a shortcode provided by this theme or any plugin. You can also add advertising code from any provider or use plain html. To add Adsense just paste the embed code here that they provide and save.', 'bluth_admin'),
				'id' => 'ad_header_code',
				'class' => 'hide ad_header_code',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Upload Image', 'bluth_admin'),
				'desc' => __('Upload an image to add above the header menu and add a link for it in the input box below', 'bluth_admin'),
				'id' => 'ad_header_image',
				'class' => 'hide ad_header_image',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Image link', 'bluth_admin'),
				'desc' => __('Add a link to the image', 'bluth_admin'),
				'id' => 'ad_header_image_link',
				'class' => 'hide ad_header_image',
				'std' => '',
				'type' => 'text');


			$options[] = array(
				'name' => __('Ad spot #2 - Between posts', 'bluth_admin'),
				'desc' => __('Here you can add advertising between posts.', 'bluth_admin'),
				'id' => 'ad_posts_mode',
				'std' => 'none',
				'type' => 'radio',
				'options' => array(
					'none' => __('None', 'bluth_admin'),
					'html' => __('Shortcode or HTML code like Adsense', 'bluth_admin'),
					'image' => __('Image with a link', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add Shortcode or HTML code here', 'bluth_admin'),
				'desc' => __('Insert a shortcode provided by this theme or any plugin. You can also add advertising code from any provider or use plain html. To add Adsense just paste the embed code here that they provide and save.', 'bluth_admin'),
				'id' => 'ad_posts_code',
				'class' => 'hide ad_posts_code',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Upload Image', 'bluth_admin'),
				'desc' => __('Upload an image to add between posts and add a link for it in the input box below', 'bluth_admin'),
				'id' => 'ad_posts_image',
				'class' => 'hide ad_posts_image',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Image link', 'bluth_admin'),
				'desc' => __('Add a link to the image', 'bluth_admin'),
				'id' => 'ad_posts_image_link',
				'class' => 'hide ad_posts_image',
				'std' => '',
				'type' => 'text');	

			$options[] = array(
				'name' => __('Display Frequency', 'bluth_admin'),
				'desc' => __('How often do you want the ad to appear?', 'bluth_admin'),
				'id' => 'ad_posts_frequency',
				'std' => 'one',
				'type' => 'select',
				'class' => 'mini hide ad_posts_options', //mini, tiny, small
				'options' => array(
					'1' => __('Between every post', 'bluth_admin'),
					'2' => __('Every 2th posts', 'bluth_admin'),
					'3' => __('Every 3th post', 'bluth_admin'),
					'4' => __('Every 4th post', 'bluth_admin'),
					'5' => __('Every 5th post', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add white background', 'bluth_admin'),
				'desc' => __('Check this to wrap the ad content in a white box', 'bluth_admin'),
				'id' => 'ad_posts_box',
				'std' => '1',
				'class' => 'hide ad_posts_options',
				'type' => 'checkbox');



			$options[] = array(
				'name' => __('Ad spot #3 - Above the content.', 'bluth_admin'),
				'desc' => __('Select what kind of ad you want added above the main container.', 'bluth_admin'),
				'id' => 'ad_content_mode',
				'std' => 'none',
				'type' => 'radio',
				'options' => array(
					'none' => __('None', 'bluth_admin'),
					'html' => __('Shortcode or HTML code like Adsense', 'bluth_admin'),
					'image' => __('Image with a link', 'bluth_admin')
				));

			$options[] = array(
				'name' => __('Add Shortcode or HTML code here', 'bluth_admin'),
				'desc' => __('Insert a shortcode provided by this theme or any plugin. You can also add advertising code from any provider or use plain html. To add Adsense just paste the embed code here that they provide and save.', 'bluth_admin'),
				'id' => 'ad_content_code',
				'class' => 'hide ad_content_code',
				'std' => '',
				'type' => 'textarea');

			$options[] = array(
				'name' => __('Upload Image', 'bluth_admin'),
				'desc' => __('Upload an image to add above the header menu and add a link for it in the input box below', 'bluth_admin'),
				'id' => 'ad_content_image',
				'class' => 'hide ad_content_image',
				'type' => 'upload');

			$options[] = array(
				'name' => __('Image link', 'bluth_admin'),
				'desc' => __('Add a link to the image', 'bluth_admin'),
				'id' => 'ad_content_image_link',
				'class' => 'hide ad_content_image',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Add white background', 'bluth_admin'),
				'desc' => __('Check this to wrap the ad content in a white box', 'bluth_admin'),
				'id' => 'ad_content_box',
				'std' => '1',
				'class' => 'hide ad_content_options',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Add padding', 'bluth_admin'),
				'desc' => __('Add padding to the banner container', 'bluth_admin'),
				'id' => 'ad_content_padding',
				'class' => 'hide ad_content_options',
				'std' => '1',
				'type' => 'checkbox');

			$options[] = array(
				'name' => __('Banner placement', 'bluth_admin'),
				'desc' => __('Where do you want the banner to appear?', 'bluth_admin'),
				'id' => 'ad_content_placement',
				'class' => 'hide ad_content_options',
				'std' => array(
					'home' => '1',
					'pages' => '1',
					'posts' => '1'
				),
				'type' => 'multicheck',
				'options' => array(
					'home' => __('Frontpage', 'bluth_admin'),
					'pages' => __('Pages', 'bluth_admin'),
					'posts' => __('Posts', 'bluth_admin')
		));

	$options[] = array(
		'name' => '<i class="icon-flow-tree"></i> ' . __('Social', 'bluth_admin'),
		'type' => 'heading');

		$options[] = array(
			'name' => __('Facebook API Options', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Facebook App Id', 'bluth_admin'),
				'desc' => __('Insert you Facebook app id here. If you don\'t have one for your webpage you can create it <a target="_blank" href="https://developers.facebook.com/apps">here</a>', 'bluth_admin'),
				'id' => 'facebook_app_id',
				'type' => 'text');
/*
		$options[] = array(
			'name' => __('Social Networks', 'bluth_admin'),
			'type' => 'info');

			$options[] = array(
				'name' => __('Facebook', 'bluth_admin'),
				'desc' => __('Your facebook link', 'bluth_admin'),
				'id' => 'social_facebook',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Twitter', 'bluth_admin'),
				'desc' => __('Your twitter link', 'bluth_admin'),
				'id' => 'social_twitter',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Google+', 'bluth_admin'),
				'desc' => __('Your google+ link', 'bluth_admin'),
				'id' => 'social_google',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('LinkedIn', 'bluth_admin'),
				'desc' => __('Your LinkedIn link', 'bluth_admin'),
				'id' => 'social_linkedin',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Youtube', 'bluth_admin'),
				'desc' => __('Your youtube link', 'bluth_admin'),
				'id' => 'social_youtube',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('RSS', 'bluth_admin'),
				'desc' => __('Your RSS feed', 'bluth_admin'),
				'id' => 'social_rss',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Flickr', 'bluth_admin'),
				'desc' => __('Your Flickr link', 'bluth_admin'),
				'id' => 'social_flickr',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Vimeo', 'bluth_admin'),
				'desc' => __('Your vimeo link', 'bluth_admin'),
				'id' => 'social_vimeo',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Pinterest', 'bluth_admin'),
				'desc' => __('Your pinterest link', 'bluth_admin'),
				'id' => 'social_pinterest',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Dribbble', 'bluth_admin'),
				'desc' => __('Your dribbble link', 'bluth_admin'),
				'id' => 'social_dribbble',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Tumblr', 'bluth_admin'),
				'desc' => __('Your tumblr link', 'bluth_admin'),
				'id' => 'social_tumblr',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Instagram', 'bluth_admin'),
				'desc' => __('Your instagram link', 'bluth_admin'),
				'id' => 'social_instagram',
				'std' => '',
				'type' => 'text');

			$options[] = array(
				'name' => __('Viadeo', 'bluth_admin'),
				'desc' => __('Your viadeo link', 'bluth_admin'),
				'id' => 'social_viadeo',
				'std' => '',
				'type' => 'text');*/
/*
	$options[] = array(
		'name' => '<i class="icon-tint"></i> ' . __('Portfolio Settings', 'bluth_admin'),
		'type' => 'heading');

			$options[] = array(
			'name' => __('Portfolio Pages', 'bluth_admin'),
			'type' => 'info');

				$options[] = array(
					'name' => __('Display Excerpt', 'bluth_admin'),
					'desc' => __('Display the excerpt on portfolio pages', 'bluth_admin'),
					'id' => 'portfolio_display_excerpt',
					'std' => '1',
					'type' => 'checkbox');

			$options[] = array(
			'name' => __('Style', 'bluth_admin'),
			'type' => 'info');	

				$options[] = array(
					'name' => __('Portfolio Style', 'bluth_admin'),
					'desc' => __('Select the default portfolio page style.', 'bluth_admin'),
					'id' => 'portfolio_style',
					'std' => 'margin',
					'type' => 'images',
					'options' => array(
						'margin' => $imagepath . 'layout-1.jpg',
						'twocolumn' => $imagepath . 'layout-2.jpg',
						'threecolumn' => $imagepath . 'layout-3.jpg',
						'fourcolumn' => $imagepath . 'layout-4.jpg',
						'fivecolumn' => $imagepath . 'layout-5.jpg',
					));*/



	return $options;
}