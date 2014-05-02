<?php

// check if we should display the description
if( ((is_home() or is_front_page()) and bl_utilities::get_option('bl_header_style') != 'description') or
	(is_single() and bl_utilities::get_option('bl_header_style_posts') != 'description') or
	(is_page() and bl_utilities::get_option('bl_header_style_pages') != 'description')){
	$display_description = true;
}else{ 
	$display_description = false;
}
// check if we should display the logo + description
if( ((is_home() or is_front_page()) and bl_utilities::get_option('bl_header_style') != 'logo_description') or
	(is_single() and bl_utilities::get_option('bl_header_style_posts') != 'logo_description') or
	(!is_single() and !is_home() and !is_front_page() and bl_utilities::get_option('bl_header_style_pages') != 'logo_description')){
	$display_logo_description = true;
}else{ 
	$display_logo_description = false;
} ?>


<div id="menu-main" class="menu-main clearfix">
	<?php if(bl_utilities::get_option('bl_menu_background') == 'shadow'){ ?> <div class="menu-shadow"></div><?php } ?>
	<?php if(bl_utilities::get_option('bl_menu_background') == 'dark_box'){ ?> <div class="menu-dark-box"></div><?php } ?>
	<div class="brand"><?php 
		// we won't display the logo and the description if it's in the header area
		if($display_logo_description){

			$logo = bl_utilities::get_option('bl_logo');
			if ( !empty( $logo ) ) { ?>
				<a class="menu-brand brand-image" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a><?php 
			}else{ ?>
				<a class="menu-brand brand-text" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><h1><?php bloginfo( 'name' ); ?></h1></a><?php 
			}
			// we won't display the description if it's in the header area or if it's disabled
			if(bl_utilities::get_option('bl_header_description') and $display_description){ ?>
				<span class="brand-description"><?php bloginfo( 'description' ); ?></span><?php 
			}

		} ?>

		 <button type="button" class="navbar-toggle visible-xs" data-toggle="collapse" data-target=".blu-top-header">
		    <span class="sr-only">Toggle navigation</span>
		    <i class="fa fa-bars"></i>
		</button>  <?php
        if(bl_utilities::get_option('bl_menu_search')){ ?>
	        <div class="blu_search pull-right hidden-sm hidden-xs">
				<?php echo get_search_form(); ?>
			</div><?php 
		} ?>
		<nav role="navigation"> <?php
			if(has_nav_menu('primary')){
	            wp_nav_menu( array(
	                'theme_location'    => 'primary',
	                'depth'             => 3,
	                'container'         => 'div',
	                'container_class' 	=> 'blu-top-header pull-right collapse navbar-collapse',
	                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	                'walker'            => new wp_bootstrap_navwalker())
	            ); 
	    	} ?>
	    </nav>
	</div>
</div>