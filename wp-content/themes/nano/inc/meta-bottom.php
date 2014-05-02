
<ul class="post-tags clearfix">
	<?php if(has_tag() && bl_utilities::get_option('bl_show_tags')){ the_tags('<li>',' ','</li>'); } ?>
</ul>

<?php 
if( ( !is_page() and bl_utilities::get_option('bl_social_footer') ) or ( is_page() and bl_utilities::get_option('bl_social_footer_pages') ) ){ ?>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 article-like-area">
				<iframe src="//www.facebook.com/plugins/like.php?href=<?php urlencode(the_permalink()); ?>&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=605249542856548" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>
				<div class="twitter-button"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>">Tweet</a></div>
				<div class="google-plus-button"><div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div></div>

		</div>
	</div><?php
}

#
#	NEXT POST
#
if(bl_utilities::get_option('bl_next_article') and is_single()){
	$next_post = get_adjacent_post( false, '', false ); 
	if( $next_post ){ 
		$next_post_url = $next_post->guid;  ?>

		<div class="article-list clearfix" style="margin-bottom:0; margin-top: 35px;">
	    	<p class="article-list-title">
	    		<?php echo blu_boldsplit(__('Next Article', 'bluth')); ?>
			</p> 
		    <div class="row">
		    	<div class="col-sm-12 col-md-12 col-lg-12">
					<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="nav-previous" style="margin-bottom:0;"> 
						<div class="post-image" style="background-image: url('<?php echo blu_get_post_image( $next_post->ID, "related-post" ); ?>'); "></div>
						<h5><?php echo blu_truncate( get_the_title( $next_post->ID ), 90, ' ', '...' );  ?></h5><br>
						<p><?php echo blu_truncate( get_the_excerpt(), 150, ' ', '...' );  ?></p>
					</a>
				</div>
			</div>
	    </div>
	    <?php /*
		<a href="<?php echo $next_post_url; ?>" class="single-pagination box" style="position: relative; z-index: 100; background-image: url('<?php echo blu_get_post_image( $next_post->ID, 'original', false ); ?>');">
			<h3><small><?php _e('Next Article', 'bluth'); ?></small><?php echo $next_post->post_title; ?></h3>
		</a> */ 
	} 
}

