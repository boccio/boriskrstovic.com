<?php
	/**
	 * The template for displaying any single page.
	 *
	 */
	get_header(); 

$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$author_ID = get_the_author_meta('ID');

?>

		<div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" role="main"><?php
			if( of_get_option('author_box_image_'.$author_ID) ){ $author_class = "has-bg"; $author_image = 'background-image:url(' . of_get_option("author_box_image_".$author_ID) . '); background-size:cover;'; }else{ $author_class = ""; $author_image = 'background-image:none;'; } ?>
			
			<div class="header-authors author-page pad30 <?php echo $author_class; ?>" style="<?php echo $author_image; ?>">
				<img class="author-image" src="<?php echo blu_get_avatar_url( get_avatar( get_the_author_meta( 'ID' ) , 'medium' )); ?>">
				<h2 class="author-name vcard author"><span class="fn blu_bold"><?php echo blu_boldsplit(get_the_author_meta( 'display_name' )); ?></span></h2> 
				<small class="author-job"><?php echo of_get_option('author_job_'.get_the_author_meta( 'ID' )); ?></small> 
				<p class="author-bio"><?php echo $curauth->description; ?></p>
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
			</div>
<?php /*
			<div class="author-meta" style="<?php echo $author_image; ?>">
				<div class="author-image"> <?php 
					if(!of_get_option('author_box_avatar_'.$author_ID)){
						echo '<img src="' . blu_get_avatar_url(get_avatar( get_the_author_meta( 'ID' ) , 120 ) ) . '">'; 
					}else{
						echo '<img src="' . of_get_option('author_box_avatar_'.$author_ID) . '">'; 
					} ?>
				</div>
				<div class="author-body">
					<h2 class="vcard author"><span class="fn"><?php echo blu_boldsplit($curauth->display_name); ?></span></h2>
					<p><?php echo $curauth->description; ?></p>
				</div>
			</div> <?php */
				$orig_post = $post;
				global $post;

				$my_query = new wp_query( array(
				    'posts_per_page'=>12,
				    'author'=>$curauth->ID, 
				    'meta_key'=> 'blu_post_views_count', 
					'orderby'=> 'meta_value_num' 
			    ));

				if($my_query->have_posts()){ ?>

			    	<div class="article-list">
			    		<div class="row article-list-title">
			    			<div class="author-posts-title col-xs-12 col-sm-12 col-md-12 col-lg-12 center uppercase pad15 clearfix">
				    			<h2><?php echo blu_boldsplit(__('Popular articles', 'bluth')); ?></h2>
				    			<h4><?php echo blu_boldsplit(__('by', 'bluth'). ' ' . $curauth->display_name); ?></h4>
				    		</div>
			    		</div>
			    		<div class="row pad35"><?php 

				 			while($my_query->have_posts()){
							    $my_query->the_post(); 
							    $post_format = get_post_format();
							    $post_format = ($post_format) ? $post_format : 'standard';   ?>
							    <div class="row">
							    	<div class="col-sm-12 col-md-12 col-lg-12">
										<a href="<?php echo get_permalink( $post->ID ); ?>" class="nav-previous"> 
											<div class="post-image" style="background-image: url('<?php echo blu_get_post_image( $post->ID, "related-post" ); ?>'); "></div><?php 
											$post_format = (get_post_format( $post->ID )) ? get_post_format( $post->ID ) : 'standard';  
											if( $post ){ ?>
												<h5><?php 
													echo blu_truncate( get_the_title( $post->ID ), 90, ' ', '...' );  ?>
												</h5><br>
												<p><?php 
													echo blu_truncate( get_the_excerpt(), 150, ' ', '...' );  ?>
												</p><?php
											} ?>
											
										</a>
									</div>
								</div> <?php
							} ?>
			    		</div>
		    		</div><?php
				}  

				wp_reset_query();

				$all_posts = new wp_query( array(
				    'posts_per_page'=>50,
				    'offset'=>1,
				    'author'=>$curauth->ID, 
			    ));

				// the rest of the authors articles
				if($all_posts->have_posts()){ ?>

			    	<div id="author-posts" class="post-box">
			    		<div class="author-posts-body col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
			    			<h2 class="center uppercase"><?php echo blu_boldsplit(__('All articles', 'bluth')); ?></h2>
				    		<h4 class="center uppercase"><?php echo blu_boldsplit(__('by', 'bluth'). ' ' . $curauth->display_name); ?></h4><?php

				 			while($all_posts->have_posts()){
							    $all_posts->the_post(); ?><?php 
									if( $post ){ ?>
										<span>&nbsp;</span>
										<a href="<?php echo get_permalink( $post->ID ); ?>">
										<h4><?php echo get_the_title( $post->ID ); ?></h4></a> <?php 
										the_excerpt(); 
									} ?>
								<?php
							} ?>
		    			</div>
		    		</div><?php
				}  ?>


		</div><!-- #content .site-content -->

<?php get_footer(); ?>