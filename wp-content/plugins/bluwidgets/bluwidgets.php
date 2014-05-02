<?php
/*
Plugin Name: Bluwidgets
Plugin URI: http://www.bluthemes.com
Description: Various Widgets from Bluthemes
Version: 1.0
Author: Bluthemes
Author URI: http://www.bluthemes.com
License: GPLv2
Tags: instagram, flickr, social, images, gallery, media, slider
*/

/*  Copyright 2014 Bluthemes  (email : bluth@bluth.is)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define( 'BLUWIDGETS_VERSION', 1.0 );
add_action( 'wp_enqueue_scripts', 'bw_assets' );

function bw_assets() {
   /* Register our stylesheet. */
    wp_enqueue_style( 'bw_style', plugins_url('bluwidgets/style.css')); 
    wp_enqueue_script( 'bw_scripts', plugins_url('bluwidgets/assets/bluwidgets.js'), array('jquery'), BLUWIDGETS_VERSION, true );

    load_plugin_textdomain('bluwidgets', false, basename( dirname( __FILE__ ) ) . '/lang' );
}
include_once('widgets/bw_instagram.php');
include_once('widgets/bw_flickr.php');