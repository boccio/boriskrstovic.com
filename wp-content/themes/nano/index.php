<?php
// Get the page layout
$layout_class = ' col-xs-12 col-sm-12 col-md-12 col-lg-12';
$layout = !bl_utilities::get_option('bl_blog_layout') ? 'right_side' : bl_utilities::get_option('bl_blog_layout');
if($layout == 'left_side'){
	$layout_class = ' pull-right col-xs-12 col-sm-12 col-md-8 col-lg-8';
}elseif($layout == 'right_side'){
	$layout_class = ' col-xs-12 col-sm-12 col-md-8 col-lg-8';
}


get_header();  ?>
	<div id="content" class="<?php echo bl_utilities::get_option('bl_blog_style'); ?> <?php echo $layout_class ?>" role="main">
		<div class="columns"><?php 
			if( have_posts() ){ 
				// count for Adspace 02
				$x = 1;
				while ( have_posts() ){
					the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-container">
							<!-- Post Title Area -->
							<div class="entry-title">
								<h1 class="meta-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h1><?php
								// we need to display this below the image if it's a link
								if(get_post_format() != 'link'){
									get_template_part( 'inc/meta-info' );
								} ?>
								
							</div>	
							<div class="entry-image-container"><?php
								get_template_part( 'inc/posts/post-thumbnail' ); ?>
							</div> 
							<div class="entry-content"> <?php
								if(bl_utilities::get_option('bl_enable_excerpt')){
									the_excerpt();
								}else{
									the_content(__('Continue reading...', 'bluth')); 
								}
								wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bluth' ), 'after' => '</div>' ) ); ?>
								<footer class="entry-meta clearfix">
									<?php get_template_part( 'inc/meta-bottom' ); ?>
								</footer><!-- .entry-meta -->
							</div><!-- .entry-content -->
						</div><!-- .entry-container -->
					</article><!-- #post-<?php the_ID(); ?> --><?php
					
					#
					# ADSPACE 02
					#
					blu_adspace_two($x);
					$x++;
				}

			}else{ 
 				get_template_part( 'inc/posts/post-404' );
 			}  ?> 
		</div><!-- .columns -->
		<?php kriesi_pagination(); ?>
	</div><!-- #content --> <?php 
	
	if($layout == 'left_side' || $layout == 'right_side'){ ?>
		<aside id="side-bar" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<div class="clearfix">
				<?php dynamic_sidebar( 'home_sidebar'); ?>
				<div id="home_sidebar_sticky" class="sticky_sidebar">
					<?php dynamic_sidebar( 'home_sidebar_sticky'); ?>
				</div>
			</div>
		</aside> <?php 
	}  ?>	
<?php get_footer(); ?>