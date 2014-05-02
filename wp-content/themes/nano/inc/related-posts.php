<?php
$orig_post = $post;
global $post;
	$tags = wp_get_post_tags($post->ID);

if($tags){
	$tag_ids = array();
	foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

	$my_query = new wp_query( array(
	    'tag__in' => $tag_ids,
	    'post__not_in' => array($post->ID),
	    'posts_per_page'=>3,
			'tax_query' => array(
	        array(
	            'taxonomy' => 'post_format',
	            'field' => 'slug',
	            'terms' => array( 'post-format-link','post-format-quote' ),
	            'operator' => 'NOT IN'
	        )
	    	)
    ));

	if($my_query->have_posts()){ ?>
	    <div class="article-list clearfix pad30 box">
	    	<p class="article-list-title">
	    		<?php echo blu_boldsplit(__('Related Articles', 'bluth')); ?>
    		</p> <?php 
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
	    </div><?php
	}
}
$post = $orig_post;
wp_reset_query();