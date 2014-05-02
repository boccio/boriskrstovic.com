<?php
	// Get the page layout
	$layout_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$page_layout = !get_post_meta( $post->ID, 'bluth_page_layout', true ) ? bl_utilities::get_option('bl_post_page_layout', 'right_side') : get_post_meta( $post->ID, 'bluth_page_layout', true );
	if($page_layout == 'left_side'){
		$layout_class = ' pull-right col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}elseif($page_layout == 'right_side'){
		$layout_class = ' col-xs-12 col-sm-12 col-md-8 col-lg-8';
	}
	$hide_title = get_post_meta( $post->ID, 'bluth_page_hide_title', 'off' );
	$post_subtitle = get_post_meta( $post->ID, 'bluth_page_subtitle', 'off' );
	get_header();  ?>

	<div id="content" class="<?php echo $layout_class; ?>" role="main">
		<?php if(have_posts()){ 
		
			while ( have_posts() ) : the_post(); 
			?>
			<article class="type-page ">
				<div class="entry-container"><?php
					if($hide_title != 'on'){ ?>
						<div class="entry-title">
							<!-- The Title -->
							<h1 class="meta-title">
								<?php the_title(); ?>
							</h1><?php
							if($post_subtitle){ ?>
								<small class="meta-sub-title">
									<?php echo $post_subtitle; ?>
								</small><?php
							} ?>
						</div><?php
					} ?>
					<div class="entry-image-container"><?php
						get_template_part( 'inc/posts/post-thumbnail' ); ?>
					</div> 
					<div class="entry-content"><?php
						the_content();
						wp_link_pages(); ?>
						<footer class="entry-meta clearfix">
							<?php get_template_part( 'inc/meta-bottom' ); ?>
						</footer><!-- .entry-meta -->	
					</div><!-- the-content -->
				</div>
			</article>

			<?php endwhile; ?>

		<?php }else{ 
 
 				get_template_part( 'inc/posts/post-404' );

 			} 
		?>

	</div><!-- #content .site-content --><?php

	if($page_layout == 'right_side' || $page_layout == 'left_side'){ ?>
		<aside id="side-bar" class="post-sidebar col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<div class="clearfix">
				<?php dynamic_sidebar( 'page_sidebar'); ?>
				<div id="page_sidebar_sticky" class="sticky_sidebar">
					<?php dynamic_sidebar( 'page_sidebar_sticky' ); ?>
				</div>
			</div>
		</aside> <?php
	}

	// If comments are open or we have at least one comment, load up the default comment template provided by Wordpress
	if ( bl_utilities::get_option('bl_page_comments') && (comments_open() || '0' != get_comments_number()) ){ ?>
		</div><!-- #primary --> 		
		</div><!-- #main --> 		
		<div class="comments row-fluid"><?php
			comments_template( '', true ); ?>
		</div><?php
	}

get_footer(); ?>