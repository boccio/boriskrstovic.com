<?php
function bluth_custom_css() {
			
global $blu_css_options;

	$blu_css_options = array(
	'custom_css' 					=> html_entity_decode(of_get_option('custom_css')),
	);

?>
<style type="text/css"> <?php 
	/*
		BACKGROUND
	*/

	// If there's a background image and the layout is boxed
	if(bl_utilities::get_option('bl_background_image') and bl_utilities::get_option('bl_theme_layout') == 'boxed'){
		$background_styling = 'url("' . bl_utilities::get_option('bl_background_image') . '") no-repeat fixed center center;';
		$background_size = 'cover';
	}
	// If there's a custom pattern
	elseif(bl_utilities::get_option('bl_background_pattern_custom')){
		$background_styling = 'url("' . bl_utilities::get_option('bl_background_pattern_custom') . '") repeat;';
		$background_size = 'auto';
	}
	// If there's a pattern
	elseif(bl_utilities::get_option('bl_background_pattern')){
		$background_styling = 'url("' . get_template_directory_uri() . '/assets/img/pattern/large/' . bl_utilities::get_option('bl_background_pattern') . '.png") repeat;';
		$background_size = 'auto';
	} 
	// If there's nothing, then use the color
	else{
		$background_styling = bl_utilities::get_option('bl_background_color');
		$background_size = 'auto';
	} ?>

	/*
		CSS
	*/

	body{ 
		background: <?php echo $background_styling; ?>;
		background-size: <?php echo $background_size; ?>;
	}
	h1, h2, h3, h4, h5, h6, .widget_calendar table > caption{ 
 		letter-spacing: <?php echo bl_utilities::get_option('bl_heading_font_letter_spacing'); ?>; 
 	}
	.main-container{
		width: <?php echo bl_utilities::get_option('bl_layout_width'); ?>px;
	}<?php
	if(is_home() or is_front_page()){ ?>
		#masthead{ <?php
	 		/* Only put a color on if the color background is selected */
	 		if(bl_utilities::get_option('bl_header_background') == 'image'){ ?>
				background-image: url("<?php echo bl_utilities::get_option('bl_header_image'); ?>");
				background-position: <?php echo bl_utilities::get_option('bl_header_image_align'); ?> center;
	 		 	<?php 
	 		} ?>
 			background-color:<?php echo bl_utilities::get_option('bl_header_color'); ?>; 
		}<?php 
	}elseif(is_single()){ ?>
		#masthead{ <?php
	 		/* if it's a single page and the featured image should be in the header */
	 		if(is_single() and get_post_meta( get_the_ID(), 'blu_image_in_header', true ) == 'on'){ ?>
				background-image: url("<?php echo blu_get_post_image(get_the_ID(), 'original'); ?>"); <?php
	 		}else{
	 			/* Only put a color on if the color background is selected */
		 		if(bl_utilities::get_option('bl_header_background_posts') == 'image'){ ?>
					background-image: url("<?php echo bl_utilities::get_option('bl_header_image_posts'); ?>");
					background-position: <?php echo bl_utilities::get_option('bl_header_image_align_posts'); ?> center;
		 		 	<?php 
		 		} ?> 
	 			background-color:<?php echo bl_utilities::get_option('bl_header_color_posts'); ?>; <?php 
			} ?>
		}<?php
	}else{ ?>
		#masthead{ <?php
	 		/* if it's a single page and the featured image should be in the header */
	 		if(is_page() and get_post_meta( get_the_ID(), 'blu_image_in_page_header', true ) == 'on'){ ?>
				background-image: url("<?php echo blu_get_post_image(get_the_ID(), 'original'); ?>"); <?php
	 		}else{
		 		/* Only put a color on if the color background is selected */
		 		if(bl_utilities::get_option('bl_header_background_pages') == 'image'){ ?>
					background-image: url("<?php echo bl_utilities::get_option('bl_header_image_pages'); ?>");
					background-position: <?php echo bl_utilities::get_option('bl_header_image_align_pages'); ?> center;
		 		 	<?php 
		 		} ?> 
	 			background-color:<?php echo bl_utilities::get_option('bl_header_color_pages'); ?>; <?php 
			} ?>
		}<?php
	} ?>
	#masthead, #masthead a, .menu-main, .menu-main ul{
		color: <?php echo bl_utilities::get_option('bl_header_font_color'); ?>;
	}
	#masthead .menu-main .blu-top-header > ul > li > a:hover, #masthead .menu-main li.current-menu-item > a, #masthead .menu-main li.current-menu-ancestor > a{
		background: <?php echo bl_utilities::get_option('bl_header_hover_background_color'); ?>;
		border-color: <?php echo bl_utilities::get_option('bl_header_hover_background_color'); ?>;
		color: <?php echo bl_utilities::get_option('bl_header_hover_font_color'); ?>!important;
	}
	#masthead .menu-main .sub-menu li a{ 
		color: <?php echo bl_utilities::get_option('bl_header_hover_background_color'); ?>;
	}
	#masthead .menu-main .sub-menu li:hover{
		background-color: <?php echo bl_utilities::get_option('bl_header_hover_background_color'); ?>;
	} 
	#masthead .menu-main .sub-menu li:hover > a{
		color: <?php echo bl_utilities::get_option('bl_header_hover_font_color'); ?>;
	}
	#masthead .menu-main .sub-menu li:hover:after, #masthead .menu-main li.current-menu-item:after, #masthead .menu-main li.current-menu-ancestor:after{
		border-color: transparent transparent <?php echo bl_utilities::get_option('bl_header_hover_background_color'); ?> transparent;
	}
	#masthead .header-area{
		border-bottom: 2px solid <?php echo bl_utilities::get_option('bl_background_color'); ?>;
	}

	/* THEME COLOR */
 	.nav > li.open > a, .nav > li > a:hover, .nav > li.open > a:hover, .nav > li > a:focus, .nav > li.open > a:focus, .nav > li.open > a:focus, .nav > li.open > a span, .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus { 
 		color:<?php echo bl_utilities::get_option('bl_theme_color'); ?>!important;
 	} 
 	.nav li a:hover .caret, .nav li.open a .caret, .nav li.open a:hover .caret, .nav li.open a:focus .caret{ 
 		border-bottom-color:<?php echo bl_utilities::get_option('bl_theme_color'); ?>;
 		border-top-color:<?php echo bl_utilities::get_option('bl_theme_color'); ?>;
 	}
 	.top-color, .top-line, .nav-line,.widget_tag_cloud .tagcloud a:hover,.gallery-item a:after,article.type-portfolio .moretag:hover,article.type-portfolio .more-link:hover{ 
 		background-color:<?php echo bl_utilities::get_option('bl_theme_color'); ?>;
 	} 
 	.site-footer #footer-body .widget_nav_menu a:hover, .site-footer #footer-body .widget_archive a:hover, .site-footer #footer-body .widget_tag_cloud a:hover, .site-footer #footer-body .widget_recent_entries a:hover, .site-footer #footer-body .widget_recent_comments li a + a:hover,.site-footer #footer-body .widget_meta a:hover, .site-footer #footer-body .widget_categories a:hover, .site-footer #footer-body .widget_pages a:hover, #bl_side_tags .bl_tab_tag:hover, .pagination > a:hover{ 
 		background-color:<?php echo  bl_utilities::get_option('bl_theme_color'); ?>;
 	} 
 	.dropdown-menu{ 
 		border-top: 2px solid <?php echo bl_utilities::get_option('bl_theme_color'); ?>;
 	} 
 	.pagination > a{ 
 		border-color: <?php echo bl_utilities::get_option('bl_theme_color'); ?>;
 	} 
 	.bl_tabs ul li .tab_text a span, a, a:hover, a:focus{ 
 		color: <?php echo bl_utilities::get_option('bl_theme_color'); ?>;
 	}

 	.entry-content{ 
 		font-size: <?php echo bl_utilities::get_option('bl_main_font_size'); ?>; 
 		line-height:<?php echo bl_utilities::get_option('bl_main_font_line_height'); ?>;
 	}
	.widget-head{
		color: <?php echo bl_utilities::get_option('bl_widget_header_font_color'); ?>;
	}

	/* HEADER SIZE */
	.menu-main{ height: <?php echo bl_utilities::get_option('bl_menu_height'); ?>px; }
	.brand, .menu-brand, .open-menu{ line-height: <?php echo bl_utilities::get_option('bl_menu_height'); ?>px; }
	.menu-brand img{ max-height: <?php echo bl_utilities::get_option('bl_menu_height'); ?>px;}
	.menu-wrapper{ top: <?php echo bl_utilities::get_option('bl_menu_height'); ?>px; }
	#masthead .header-authors, #masthead .header-description, #masthead .header-html{ padding: <?php echo 150 - bl_utilities::get_option('bl_menu_height'); ?>px 0 150px 0; }

	/* HEADER BACKGROUND COLOR */
	.menu-main, 
 	.menu-main ul, 
 	.menu-wrapper, 
 	.menu-search .searchform input{
 	}
	.comments{
		background: <?php echo bl_utilities::get_option('bl_comments_background_color'); ?>;
	}
	.comments h3{
		color: <?php echo bl_utilities::get_option('bl_comments_title_font_color'); ?>;	
	}
	.site-footer{
		background: <?php echo bl_utilities::get_option('bl_footer_background_color'); ?>;
	}
	#footer-body > div ul li a, 
 	.site-footer > *{
		color: <?php echo bl_utilities::get_option('bl_footer_font_color'); ?>;
	}
	.site-footer .widget-head{
		color: <?php echo bl_utilities::get_option('bl_footer_header_font_color'); ?>;
	}

	/* BLOG */
	<?php
	// make tags look like hashtags
	if(bl_utilities::get_option('bl_hashtags')){ ?>
		a[rel=tag]:before, .tagcloud a:before{
			content: '#';
			display: inline;
		}<?php
	}

	if(bl_utilities::get_option('bl_standard_post_color')){
		
		$post_format_color['standard'] 	= bl_utilities::get_option('bl_standard_post_color');
		$post_format_color['gallery'] 	= bl_utilities::get_option('bl_gallery_post_color');
		$post_format_color['quote'] 	= bl_utilities::get_option('bl_quote_post_color');
		$post_format_color['link'] 		= bl_utilities::get_option('bl_link_post_color');
		$post_format_color['audio'] 	= bl_utilities::get_option('bl_audio_post_color');
		$post_format_color['video'] 	= bl_utilities::get_option('bl_video_post_color');
		$post_format_color['status'] 	= bl_utilities::get_option('bl_status_post_color');
		$post_format_color['sticky'] 	= bl_utilities::get_option('bl_sticky_post_color');

		foreach($post_format_color as $name => $color){ ?>

			.post-format-<?php echo $name ?>,
			.format-<?php echo $name ?> .post-meta ~ * a, 
			.format-<?php echo $name ?> .post-meta a:hover, 
			.format-<?php echo $name ?> .meta-title a:hover,
			.format-<?php echo $name ?> a.moretag,
			.format-<?php echo $name ?> a.more-link{
				color: <?php echo $color ?>;
			}
			.tab_<?php echo $name ?>,  
			.format-<?php echo $name ?> a.moretag:hover, 
			.format-<?php echo $name ?> a.more-link:hover, 
			.format-<?php echo $name ?> .entry-image .entry-category a,
			.format-<?php echo $name ?> .entry-image > a:after,
			.format-<?php echo $name ?> .page-links > a:hover,
			.format-<?php echo $name ?> .page-links > span{
				background-color: <?php echo $color ?>;
			}
			.format-<?php echo $name ?> *::selection{
				color: #FFFFFF;
				background-color: <?php echo $color ?>;
			}
			.format-<?php echo $name ?> *::-moz-selection{
				color: #FFFFFF;
				background-color: <?php echo $color ?>;
			}
			.format-<?php echo $name ?> a.moretag,
			.format-<?php echo $name ?> a.more-link,
			.format-<?php echo $name ?> .page-links > a:hover,
			.format-<?php echo $name ?> .page-links > span{
				border-color: <?php echo $color; ?>;
			} 
			.format-<?php echo $name ?> footer.entry-meta .post-tags li a:hover,
			.post-format-badge.post-format-<?php echo $name; ?>{
				color: <?php echo $color ?>; 
			}
			article.type-post.format-<?php echo $name ?> p a, 
			article.type-post.format-<?php echo $name ?> p a:hover span:before, 
			article.type-post.format-<?php echo $name ?> p a:focus span:before{
				color: <?php echo $color ?>; 
			} <?php
		} ?>
		/* sticky post */
		article.sticky .sticky-icon:after{
			border-color: <?php echo bl_utilities::get_option('bl_sticky_post_color'); ?> <?php echo bl_utilities::get_option('bl_sticky_post_color'); ?> transparent;
		} <?php

		if(!empty($blu_css_options['sticky_post_color'])){
			echo '.sticky .post-format-badge{color: '.$blu_css_options['sticky_post_color'].'};';
			echo '.sticky .post-meta ~ * a, .sticky .post-meta a:hover, .sticky .meta-title a:hover{color: '.$blu_css_options['sticky_post_color'].';}';
		}
	}

	/*
		CUSTOM CSS
	*/
	echo bl_utilities::get_option('bl_custom_css');

	?>
</style>


<?php
if(1 == 2){ ?>
<style type="text/css"> <?php

	if(!empty($blu_css_options['post_header_color'])){ ?>
	 	.meta-title a{ color:<?php echo $blu_css_options['post_header_color']; ?>; }  <?php
	}
	if(!empty($blu_css_options['header_font_color'])){ ?>
	 	#masthead, 
	 	#masthead .nav a, 
	 	#masthead h1, 
	 	#masthead h1 small{
	 		color:<?php echo $blu_css_options['header_font_color']; ?>; 
	 	} 
	 	.header-authors .author-social a {
	 		border-color: <?php echo $blu_css_options['header_font_color']; ?>;
	 	}
	 	.nav a .caret{ 
	 		border-bottom-color:<?php echo $blu_css_options['header_font_color']; ?>; 
	 		border-top-color:<?php echo $blu_css_options['header_font_color']; ?>; 
	 	}  <?php
	}



	?>
</style>
<?php }
}
add_action( 'wp_head', 'bluth_custom_css', 100 );
?>