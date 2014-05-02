<?php

	// Count view
	blu_set_post_views(get_the_ID());
	// Get the page layout
	$layout_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$post_layout = !get_post_meta( $post->ID, 'bluth_post_layout', true ) ? bl_utilities::get_option('bl_post_page_layout', 'right_side') : get_post_meta( $post->ID, 'bluth_post_layout', true );

	if($post_layout == 'left_side'){
		$layout_class = ' pull-right col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}elseif($post_layout == 'right_side'){
		$layout_class = ' col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}
	get_header();	


	$image_comment_class = bl_utilities::get_option('bl_image_comments') ? 'image-comment-on' : ''; ?>
	<div id="content" class="<?php echo $image_comment_class.$layout_class; ?> " role="main"> <?php 
		if ( have_posts() ){
	 		while ( have_posts() ) : the_post();  ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-container">
						<div class="entry-title">
							<!-- The Title -->
							<h1 class="meta-title">
								<?php the_title(); ?>
							</h1><?php
							// we need to display this below the image if it's a link
							if(get_post_format() != 'link'){
								get_template_part( 'inc/meta-info' );
							} ?>
						</div>
						<div class="entry-image-container"><?php
							get_template_part( 'inc/posts/post-thumbnail' ); ?>
						</div> 
						<div class="entry-content"><?php
							the_content(); 
					      	// paginated posts
					       	wp_link_pages( array( 'before' => '<div class="page-links"><h4>'.__( 'Pages:', 'bluth' ).'</h4>', 'link_before' => '<span>', 'after' => '</div>', 'link_after' => '</span>', 'pagelink' => '%')); ?>
							<footer class="entry-meta clearfix">
								<?php get_template_part( 'inc/meta-bottom' ); ?>
							</footer><!-- .entry-meta -->
						</div><!-- .entry-content -->  
					</div><!-- .entry-container -->
				</article><!-- #post-<?php the_ID(); ?> --><?php		
			endwhile;				
			// show related posts by tag
			if(bl_utilities::get_option('bl_related_posts')){ 
			 	get_template_part( 'inc/related-posts' ); 
			}
		}else{

			get_template_part( 'inc/posts/post-404' );

		} ?>
	</div><!-- #content .site-content --><?php

	if($post_layout == 'left_side' || $post_layout == 'right_side'){ ?>
		<aside id="side-bar" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<div class="clearfix">
				<?php dynamic_sidebar( 'post_sidebar'); ?>
				<div id="post_sidebar_sticky" class="sticky_sidebar">
					<?php dynamic_sidebar( 'post_sidebar_sticky'); ?>
				</div>
			</div>

		</aside> <?php 
	} 

	// If comments are open or we have at least one comment, load up the default comment template provided by Wordpress
	if ( comments_open() || '0' != get_comments_number() ){ ?>
		</div> <!-- #primary -->
		</div> <!-- #main -->
		<div class="comments row-fluid"><?php
			comments_template( '', true ); ?>
		</div><?php
	}

get_footer(); ?>
