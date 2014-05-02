<?php 


// if(!of_get_option('disable_share_story')){
if(bl_utilities::get_option('bl_show_share_buttons')){
	$show_share_buttons = false;
	
	if(is_single() && in_array(bl_utilities::get_option('bl_show_share_buttons_on'), array('all','only_posts','only_posts_front','only_posts_pages'))){
		$show_share_buttons = true;
	}
	if(is_page() && in_array(bl_utilities::get_option('bl_show_share_buttons_on'), array('all','only_pages','only_pages_front','only_posts_pages'))){
		$show_share_buttons = true;
	}
	if((is_home() or is_front_page()) && in_array(bl_utilities::get_option('bl_show_share_buttons_on'), array('all','only_front','only_posts_front','only_pages_front'))){
		$show_share_buttons = true;
	}
	
	
	if( $show_share_buttons ){
		$share_title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
		$share_url = urlencode(get_permalink()); ?>
		<div class="share-story-container">
			<a href="javascript:void(0);" class="open-container">+</a>
			<ul class="share-story">
				<?php if(bl_utilities::get_option('bl_show_share_buttons_facebook')){ ?><li><a class="tips social-facebook" data-placement="right" data-title="Facebook" href="javascript:void(0);" onClick="social_share('http://www.facebook.com/sharer.php?u=<?php echo $share_url; ?>&t=<?php echo $share_title; ?>');"><i class="fa fa-facebook"></i></a></li><?php } ?>
				<?php if(bl_utilities::get_option('bl_show_share_buttons_google')){ ?><li><a class="tips social-gplus" data-placement="right" data-title="Google+" href="javascript:void(0);" onClick="social_share('https://plus.google.com/share?url=<?php echo $share_url; ?>');"><i class="fa fa-google-plus"></i></a></li><?php } ?>
				<?php if(bl_utilities::get_option('bl_show_share_buttons_twitter')){ ?><li><a class="tips social-twitter" data-placement="right" data-title="Twitter" href="javascript:void(0);" onClick="social_share('http://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php the_title(); ?>');"><i class="fa fa-twitter"></i></a></li><?php } ?>
				<?php if(bl_utilities::get_option('bl_show_share_buttons_linked')){ ?><li><a class="tips social-linkedin" data-placement="right" data-title="Linkedin" href="javascript:void(0);" onClick="social_share('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>');"><i class="fa fa-linkedin"></i></a></li><?php } ?>
				<?php if(bl_utilities::get_option('bl_show_share_buttons_email')){ ?><li><a class="tips social-email" data-placement="right" data-title="Email" href="javascript:void(0);" onClick="social_share('mailto:?subject=<?php echo $share_title;?>&amp;body=<?php echo $share_url ?>');"><i class="fa fa-envelope"></i></a></li><?php } ?>
			</ul>
		</div><?php
	} 
}