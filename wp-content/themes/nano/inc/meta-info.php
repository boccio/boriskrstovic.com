<div class="meta-info">
	<div class="info-author"><?php echo __('by', 'bluth'). ' '; the_author_posts_link(); ?></div>
	<div class="info-date">
		<time class="timeago tips" title="<?php echo get_the_date(); ?>" datetime="<?php echo get_the_date(); ?>"></time>
	</div>
	<div class="info-comments"><?php comments_number(); ?></div>
	<?php get_template_part( 'inc/meta-share' ); ?>
	<div class="info-category">
		<ul class="unstyled"><?php
			$categories = get_the_category();
			$firstcategory = true;

			foreach($categories as $category) { ?>
				<li style="display:inline;" class="post-meta-category"><span style="display:inline;"></span><?php if($firstcategory){ echo __('in', 'bluth'). ' '; }else{ echo __('and', 'bluth'). ' '; } ?><a href="<?php echo get_category_link( $category->term_id ); ?>" title="<?php _e('View all posts in', 'bluth'); ?> <?php esc_attr( $category->name); ?>"><?php echo $category->cat_name; ?></a></li> <?php
				$firstcategory = false;
			} ?>
		</ul>
	</div>
</div>