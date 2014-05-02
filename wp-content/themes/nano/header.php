<!DOCTYPE html>
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>><?php

	// background stripe
	if(bl_utilities::get_option('bl_background_stripe', false)){ ?> 
		<div id="stripe"></div><?php
	} 
	// Facebook Javascript SDK
	if(of_get_option('facebook_app_id')){ blu_facebook_sdk(); }	

	blu_adspace_one(); ?>

<div id="page" class="site <?php echo bl_utilities::get_option('bl_theme_layout') == 'boxed' ? 'main-container container' : ''; ?>">
	<?php do_action( 'before' ); ?>
	<div id="masthead" class="masthead-container">
		<header role="banner">
			<?php get_template_part( 'inc/header/header', 'menu' ); ?>
		</header><?php 
		
		#
		#	HEADER AREA
		#
		get_template_part( 'inc/header/header', 'area' ); ?>


	</div>

	<div id="main" class="<?php echo bl_utilities::get_option('bl_theme_layout') != 'boxed' ? 'main-container container' : ''; ?>">
		<div id="primary" class="row <?php echo of_get_option('side_bar', 'right_side'); ?>"> <?php	
			blu_adspace_three();