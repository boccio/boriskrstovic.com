<?php
	// Define the version so we can easily replace it throughout the theme
	define( 'NANO_VERSION', 1.0 );
	define( 'BLUTHEMES', true );	

	/*  Set the content width based on the theme's design and stylesheet  */
	if ( !isset( $content_width ) ){ $content_width = 750; }

	/*  Register main menu for Wordpress use  */
	if(!function_exists('bluth_register_nav_menu')){
		function bluth_register_nav_menu() {
			register_nav_menus(  array( 'primary'	=>	'Primary Menu' ) ); // Register the Primary menu  
		}
	}
	add_action( 'after_setup_theme', 'bluth_register_nav_menu' );

	/* Include the TGM_Plugin_Activation class  */
	include_once('inc/classes/bl_activate.php');
	add_action('tgmpa_register', 'blu_register_required_plugins');
	/* Custom bluth assets  */
	require_once('inc/assets.php');
	/* Custom bluth functions  */
	require_once('inc/custom-functions.php');
	/* Bluthcodes */
	include_once 'assets/plugins/bluthcodes/codes.php'; 