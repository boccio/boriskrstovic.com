<?php
	
	#
	#	GENERAL
	#
	
	// Theme Setup
	if(!function_exists('blu_theme_setup')){
		function blu_theme_setup(){
			add_editor_style( 'assets/css/style-editor.css' );

			/*  Post Thumbnails  */
			if ( function_exists( 'add_image_size' ) ) {
				$bl_featured_image_width = !of_get_option('featured_image_cropped_width') ? 980 : of_get_option('featured_image_cropped_width');
				$bl_featured_image_height = !of_get_option('featured_image_cropped_height') ? 500 : of_get_option('featured_image_cropped_height');

				add_theme_support( 'post-thumbnails' );

				add_image_size( 'single-large', $bl_featured_image_width, $bl_featured_image_height, true );		// Featured Widget Image
				add_image_size( 'sidebar-large', $bl_featured_image_width, $bl_featured_image_height, true );		// Featured Widget Image

				add_image_size( 'large_header', 1280, 500, true );		// Large Header Image
				add_image_size( 'featured_post', 400, 250, true );		// Featured Widget Image
				add_image_size( 'share', 700, 300, true );				// Standard Blog Image
				add_image_size( 'related-post', 350, 450, true ); 		// Related posts image
				add_image_size( 'small', 194, 150, true ); 				// Related posts image
				add_image_size( 'mini', 80, 80, true ); 				// Sidebar widget image
			}

			/* other */
			add_action( 'comment_post', 'blu_add_custom_comment_field', 1 );
		}
	}

	#
	#	HEADER
	#
	
	// Outputs the selected option panel styles inline into the <head>
	if(!function_exists('blu_header_assets')){ 
		function blu_header_assets() {

			#
			#	TYPOGRAPHY 
			#
			$output = '';
			$logo_font 			= bl_utilities::get_option('bl_logo_font');
			$heading_font 		= bl_utilities::get_option('bl_heading_font');
			$text_font 			= bl_utilities::get_option('bl_main_font');
			$menu_font 			= bl_utilities::get_option('bl_menu_font');
			$header_font 		= bl_utilities::get_option('bl_brand_font');

			if($logo_font){
				$selected_font = explode(':', $logo_font);
				$output .= '.menu-brand h1{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",serif;}';
			}

			if($heading_font){
				$selected_font = explode(':', $heading_font);
				$output .= 'h1,h2,h3,h4,h5{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",serif;} .widget_calendar table > caption{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",serif;} ';
			}

			if($text_font){
				$selected_font = explode(':', $text_font);
				$output .= 'body{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",Helvetica,sans-serif;} ';
			}

			if($menu_font){
				$selected_font = explode(':', $menu_font);
				$output .= '.menu-main, .menu-main ul{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",Helvetica,sans-serif;} ';
			}

			if($header_font){
				$selected_font = explode(':', $header_font);
				$output .= '#masthead{font-family: "'.str_replace('+', ' ', $selected_font[0]).'",Helvetica,sans-serif;} ';
			}

		    if ( $output != '' ) {
				$output = "\n<style>\n" . $output . "</style>\n";
				echo $output;
		    }

		    #
		    #	OPEN GRAPH
		    #
		    // only run this function if the user is not using an seo plugin
			if ( !of_get_option('seo_plugin') ){

				// add title tag
				echo '<title>';
				bloginfo('name');
				wp_title(' - ', true, 'left');
				echo '</title>';

				// og:site_name
				echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '" />';

				// og:title
				echo '<meta property="og:title" content="';
				bloginfo('name');
				wp_title(' - ', true, 'left');
				echo '" />';

				if(of_get_option('facebook_app_id')){
					echo '<meta property="fb:app_id" content="' . of_get_option('facebook_app_id') . '" />';
				}

				if (is_single() || is_page() ){ 
					if ( have_posts() ) {
						while ( have_posts() ){ 
							the_post();
							echo '<meta property="og:description" content="' . mb_substr(strip_tags(get_the_excerpt()), 0, 155) . '" />';
							echo '<meta property="og:image" content="' . blu_get_post_image(get_the_ID(), 'share', true ) . '" />';
						} 
					// og:type
					echo '<meta property="og:type" content="article" />'; 
					// og:url
					echo '<meta property="og:url" content="'.get_permalink().'"/>';	
					}
				}elseif(is_home()){ 
					echo '<meta property="og:description" content="';
					bloginfo('description');
					echo '" />';
					
					// og:url
					echo '<meta property="og:url" content="' . get_home_url() . '" />';					
				}else{
					// og:type
					echo '<meta property="og:type" content="website" />';
				}
			}

		    #
		    #	FAVICON
		    #
		  	if(bl_utilities::get_option('bl_favicon')){
		   		echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . bl_utilities::get_option('bl_favicon') . '" />';
	  		}

		    #
		    #	APPLE TOUCH ICON
		    #
		    if(bl_utilities::get_option('bl_apple_touch_icon')){
				echo '<link rel="apple-touch-icon" href="' . bl_utilities::get_option('bl_apple_touch_icon') . '" />';
		    }
		    
		    #
		    #	GOOGLE TRACKING CODE
		    #
			if($google_analytics = of_get_option('google_analytics', false)){
				echo (strpos($google_analytics, '<script') === false) ? '<script>'.of_get_option('google_analytics').'</script>' : of_get_option('google_analytics');
			}

		    #
		    #	CUSTOM JAVASCRIPT
		    #
			if($custom_js = bl_utilities::get_option('bl_custom_javascript')){
				echo (strpos($custom_js, '<script') === false) ? '<script type="text/javascript">'.$custom_js.'</script>' : $custom_js;
			}
		}
	}
	if(!function_exists('blu_facebook_sdk')){
		// Facebook Javascript API
		function blu_facebook_sdk(){ ?>
			<div id="fb-root"></div>
			<script>
				function get_facebook_sdk(){
					(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=<?php echo of_get_option('facebook_app_id'); ?>";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				}
				jQuery(function(){
					get_facebook_sdk();
				});
			</script><?php
		}
	}

	#
	#	COMMENTS
	#
	
	// Bluthemes Comments
	if(!function_exists('blu_comment')){
		function blu_comment( $comment, $args, $depth ) {
			global $post;
		    $GLOBALS['comment'] = $comment;
		    $comment_meta = get_comment_meta( get_comment_ID(), 'image_location', true );
		    $comment_meta = explode(',', $comment_meta); 
		    // $score_meta = get_comment_meta( get_comment_ID(), 'blu_comment_score', true ) ? get_comment_meta( get_comment_ID(), 'blu_comment_score', true ) : '0';
		    $image_class = !empty($comment_meta[2]) ? 'image-comment-on' : '';
		    // hide the comment a bit if it has a score below 0
		    $hide_comment_class = ($comment->comment_karma < 0) ? ' mute ' : '';
		    $comment_class = ($comment->comment_karma > 0) ? 'up' : (($comment->comment_karma) < 0 ? 'down' : 'null');

		    switch ( $comment->comment_type ) :
		        case 'pingback' :
		        case 'trackback' :
		    ?>
		    <li class="post pingback box">
		        <p><?php _e( 'Pingback:', 'bluth' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'bluth' ), ' ' ); ?></p>
		    <?php
		            break;
		        default :
		    ?>
		    <li <?php comment_class( $image_class . $hide_comment_class ); ?> id="li-comment-<?php comment_ID(); ?>">
		    	<div class="author-avatar"><?php echo get_avatar( $comment, 75 ); ?></div>
		        <article id="comment-<?php comment_ID(); ?>" class="comment box">

		            <div class="comment-content clearfix"> 

		                <div class="comment-author clearfix">
		                    <?php printf( __( '%s', 'bluth' ), sprintf( '<h4 class="commenter">%s' . ($comment->user_id == get_queried_object()->post_author ? '<a href="#" class="blu-color" title="' . __("Author", "bluth") . '"><i class="icon-star-1"></i></a>' : '') . '</h4>', get_comment_author_link() ) ); ?>
		                </div><!-- .comment-author -->
		            	<?php 
		            	if(!empty($comment_meta[2])){
	            			echo '<div class="image-comment-crop"><img style="width: ' . $comment_meta[3] . 'px; left: ' . (((int)$comment_meta[1]*-1)+20) . 'px; top: ' . ((int)$comment_meta[0]*-1) . 'px; " src="' . ($comment_meta[2]) . '"></div>'; 
		            	}
		            	comment_text(); ?>
		            </div>
	                	<!-- 
	                		COMMENT SCORE 
	                	-->
	                	<div class="comment-score">
	                		<a href="#" class="blu-comment-vote blu-comment-vote-up" data-commentid="<?php echo get_comment_ID(); ?>">
	                			<i class="fa fa-arrow-up"></i>
	                		</a> 
	                		<div class="total-score vote-<?php echo $comment_class; ?>"><?php echo $comment->comment_karma; ?></div> 
	                		<a href="#" class="blu-comment-vote blu-comment-vote-down" data-commentid="<?php echo get_comment_ID(); ?>">
	                			<i class="fa fa-arrow-down"></i>
	                		</a>
	                	</div>
	                	<!-- 
	                		/ COMMENT SCORE 
	                	-->
	                <?php if ( $comment->comment_approved == '0' ) : ?>
	                    <em><?php _e( 'Your comment is awaiting moderation.', 'bluth' ); ?></em>
	                    <br />
	                <?php endif; ?>
		            <div class="reply">
		                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		                <?php edit_comment_link( __( '(Edit)', 'bluth' ), '&nbsp;&nbsp;' ); ?>
		            </div><!-- .reply -->
		            <div class="date">
		            	<time class="timeago tips" title="<?php echo $comment->comment_date; ?>" datetime="<?php echo $comment->comment_date; ?>"></time>
		            </div><!-- .date -->
		        </article><!-- #comment-## -->
		 
		    <?php
		            break;
		    endswitch;
		}
	}
	// Comment meta
	if(!function_exists('blu_add_custom_comment_field')){
		function blu_add_custom_comment_field( $comment_id ) {
		   add_comment_meta( $comment_id, 'image_location', $_POST['image_location'], true );
		}
	}
	// Comment score
	if(!function_exists('blu_ajax_comment_score')){
		function blu_ajax_comment_score(){  
			$commentid = $_POST['commentid']; 
			$comment = get_comment($_POST['commentid']);
			$vote_type = $_POST['votetype'];
			$karma = $comment->comment_karma;

			// hasn't voted before
			if( !in_array(blu_get_ip(), get_comment_meta( $commentid, 'blu_comment_ip')) ){
				if($vote_type == 'up'){
					$karma++;
				}else{
					$karma--;
				}
				wp_update_comment(array('comment_ID' => $commentid, 'comment_karma' => $karma));
				add_comment_meta($_POST['commentid'], 'blu_comment_ip', blu_get_ip(), false);
				die();

			// already commented
			}else{
				echo 'already voted ';
				return false;
				die();
			}
		}
	} 

	#
	#	POSTS
	#
	
	// Custom Pagination ( thanks to kriesi.at )
	if(!function_exists('kriesi_pagination')){ 
		function kriesi_pagination($pages = '', $range = 2){  
		     $showitems = ($range * 2)+1;  

		     global $paged;
		     if(empty($paged)) $paged = 1;

		     if($pages == ''){
		         global $wp_query;
		         $pages = $wp_query->max_num_pages;
		         if(!$pages){
		             $pages = 1;
		         }
		     }   
		     if(1 != $pages){
		        echo "<div class='pagination box'>";
				echo get_previous_posts_link( '<i class="icon-left-open-1"></i> '.__('Previous Page', 'bluth') );
		         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a class='' href='".get_pagenum_link(1)."'>&laquo;</a>";
		         if($paged > 1 && $showitems < $pages) echo "<a class='box' href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
		         for ($i=1; $i <= $pages; $i++){
		             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
		                 echo ($paged == $i)? "<span class='current '>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive ' >".$i."</a>";
		             }
		         }
		         if ($paged < $pages && $showitems < $pages) echo "<a class='' href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
		         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a class='' href='".get_pagenum_link($pages)."'>&raquo;</a>";
				echo get_next_posts_link( __('Next Page', 'bluth').' <i class="icon-right-open-1"></i>' );
		        echo "</div>\n";
		     }
		}
	}
	// Add a Lightbox class to all inserted images
	if(!function_exists('blu_lightbox_class')){
		function blu_lightbox_class($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
		  $classes = 'lightbox'; // separated by spaces, e.g. 'img image-link'

		  // check if there are already classes assigned to the anchor
		  if ( preg_match('/<a.*? class=".*?">/', $html) ) {
		    $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
		  } else {
		    $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
		  }
		  return $html;
		}
	}
	// Retina Images add to image import
	if(!function_exists('blu_retina_support')){
		function blu_retina_support( $metadata, $attachment_id ) {
		    foreach ( $metadata as $key => $value ) {
		        if ( is_array( $value ) ) {
		            foreach ( $value as $image => $attr ) {
		                if ( is_array( $attr ) )
		                    blu_retina_support_create_images( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
		            }
		        }
		    }
		 
		    return $metadata;
		}
	}
	// Retina Images create images
	if(!function_exists('blu_retina_support_create_images')){
		function blu_retina_support_create_images( $file, $width, $height, $crop = false ) {
		    if ( $width || $height ) {
		        $resized_file = wp_get_image_editor( $file );
		        if ( ! is_wp_error( $resized_file ) ) {
		            $filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );
		 
		            $resized_file->resize( $width * 2, $height * 2, $crop );
		            $resized_file->save( $filename );
		 
		            $info = $resized_file->get_size();
		 
		            return array(
		                'file' => wp_basename( $filename ),
		                'width' => $info['width'],
		                'height' => $info['height'],
		            );
		        }
		    }
		    return false;
		}
	}
	// Delete retina images when user deletes an image
	if(!function_exists('blu_retina_support_create_images')){
		function blu_delete_retina_support_images( $attachment_id ) {
		    $meta = wp_get_attachment_metadata( $attachment_id );
		    $upload_dir = wp_upload_dir();
		    $path = pathinfo( $meta['file'] );
		    foreach ( $meta as $key => $value ) {
		        if ( 'sizes' === $key ) {
		            foreach ( $value as $sizes => $size ) {
		                $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
		                $retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
		                if ( file_exists( $retina_filename ) )
		                    unlink( $retina_filename );
		            }
		        }
		    }
		}
	}


	#
	#	ADSPACES
	#
	
	// Adspace one (Above Header)
	if(!function_exists('blu_adspace_one')){
		function blu_adspace_one(){

			$ad_header_mode = of_get_option('ad_header_mode', 'none');

			if($ad_header_mode != 'none'){ ?>
				<div class="above_header"><?php
					if($ad_header_mode == 'image'){ ?>
						<a href="<?php echo of_get_option('ad_header_image_link'); ?>" target="_blank"><img src="<?php echo of_get_option('ad_header_image'); ?>"></a><?php
					}elseif($ad_header_mode == 'html'){
						echo apply_filters('shortcode_filter', do_shortcode(of_get_option('ad_header_code')));
					} ?>
				</div><?php
			}
		}
	}
	// Adspace two (Between Posts)
	if(!function_exists('blu_adspace_two')){
		function blu_adspace_two($x){

			$ad_posts_mode 			= of_get_option('ad_posts_mode', 'none');
			$ad_posts_frequency 	= of_get_option('ad_posts_frequency', 'none');
			$ad_posts_box 			= of_get_option('ad_posts_box', true);

			if($ad_posts_mode != 'none'){
				// take into account ad frequency
				if (($x % $ad_posts_frequency) == 0){
					switch ($ad_posts_mode) {
						case 'image':
							echo '<div class="'.(($ad_posts_box) ? 'box' : '').' between_posts"><a target="_blank" href="'.of_get_option('ad_posts_image_link').'"><img src="'.of_get_option('ad_posts_image').'"></a></div>';
						break;
						case 'html':
							echo '<div class="'.(($ad_posts_box) ? 'box' : '').' between_posts">'.apply_filters('shortcode_filter',do_shortcode(of_get_option('ad_posts_code'))).'</div>';
						break;
					}
				}
			}
		}
	}
	// Adspace three (Above Content)
	if(!function_exists('blu_adspace_three')){
		function blu_adspace_three(){

			$ad_content_box 		= of_get_option('ad_content_box', true);
			$ad_content_padding 	= of_get_option('ad_content_padding', true);
			$ad_content_mode 		= of_get_option('ad_content_mode', 'none');
			$ad_content_placement 	= of_get_option('ad_content_placement', array('home' => true,'pages' => true,'posts' => true));

			if($ad_content_mode != 'none' and (( $ad_content_placement['home'] == true and ( is_home() or is_front_page() ) ) or ( $ad_content_placement['posts'] == true and is_single() ) or ( $ad_content_placement['pages'] == true and is_page() ) ) ){ ?>
				<div class="above_content col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="<?php echo ($ad_content_box ? ' box' : '').($ad_content_padding ? ' pad15' : ''); ?>"><?php
						if($ad_content_mode == 'image'){ ?>
							<a href="<?php echo of_get_option('ad_content_image_link'); ?>" target="_blank"><img src="<?php echo of_get_option('ad_content_image'); ?>"></a><?php
						}elseif($ad_content_mode == 'html'){
							echo apply_filters('shortcode_filter', do_shortcode(of_get_option('ad_content_code')));
						} ?>
					</div>
				</div><?php
			}
		}
	}

	#
	#	HELPERS
	#
	
	// Get user IP
	if(!function_exists('blu_get_ip')){
		function blu_get_ip(){
		    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
		    {
		        if (array_key_exists($key, $_SERVER) === true)
		        {
		            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
		            {
		                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
		                {
		                    return $ip;
		                }
		            }
		        }
		    }
		}
	}
	// Google ads
	if(!function_exists('blu_get_google_ads')){
		function blu_get_google_ads(){ 
			global $blu_google_ads_count;
			$blu_google_ads_count++;
			?>
			<div style="text-align: center;">
				<div id="google-ads-<?php echo $blu_google_ads_count; ?>" class="google-ads"></div>
			       
				<script type="text/javascript">

				    /* Calculate the width of available ad space */
				    ad = jQuery('#google-ads-<?php echo $blu_google_ads_count; ?>')[0];
				     
				    if (ad.getBoundingClientRect().width) {
				   	 	adWidth = ad.getBoundingClientRect().width; // for modern browsers
				    } else {
				    	adWidth = ad.offsetWidth; // for old IE
				    }
				     
				    /* Replace ca-pub-XXX with your AdSense Publisher ID */
				    google_ad_client = "<?php echo of_get_option('google_publisher_id', '0'); ?>";
				     
				    /* Replace 1234567890 with the AdSense Ad Slot ID */
				    google_ad_slot = "<?php echo of_get_option('google_ad_unit_id', '0'); ?>";
				    /* Do not change anything after this line */
				    if ( adWidth >= 728 )
				    	google_ad_size = ["728", "90"]; /* Leaderboard 728x90 */
				    else if ( adWidth >= 468 )
				    	google_ad_size = ["468", "60"]; /* Banner (468 x 60) */
				    else if ( adWidth >= 336 )
				    	google_ad_size = ["336", "280"]; /* Large Rectangle (336 x 280) */
				    else if ( adWidth >= 300 )
				    	google_ad_size = ["300", "250"]; /* Medium Rectangle (300 x 250) */
				    else if ( adWidth >= 250 )
				    	google_ad_size = ["250", "250"]; /* Square (250 x 250) */
				    else if ( adWidth >= 200 )
				    	google_ad_size = ["200", "200"]; /* Small Square (200 x 200) */
				    else if ( adWidth >= 180 )
				    	google_ad_size = ["180", "150"]; /* Small Rectangle (180 x 150) */
				    else
				    	google_ad_size = ["125", "125"]; /* Button (125 x 125) */
				     

				    document.write (
				    '<ins class="adsbygoogle" style="display:inline-block;width:'
				    + google_ad_size[0] + 'px;height:'
				    + google_ad_size[1] + 'px" data-ad-client="'
				    + google_ad_client + '" data-ad-slot="'
				    + google_ad_slot + '"></ins>'
				    );
				    (adsbygoogle = window.adsbygoogle || []).push({});

				</script>
				 
				<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
				</script>
			</div><?php
		}
	}
	// Add span tag around categories post count
	if(!function_exists('blu_cat_count_span')){ 
		function blu_cat_count_span($links) {
			return str_replace(array('</a> (',')'), array('</a> <span class="badge">','</span>'), $links);
		}
	}
	// Add span tag around archives post count
	if(!function_exists('blu_archive_count_span')){ 
		function blu_archive_count_span($links) {
		  	return str_replace(array('</a>&nbsp;(',')'), array('</a> <span class="badge">','</span>'), $links);
		}
	}
	// Replaces the excerpt "more" text by a link
	if(!function_exists('blu_excerpt_more')){ 
		function blu_excerpt_more($more) {
			if( !is_single() ){
		    	global $post;
	    		return false;
			}
		}
	}
	// Manual excerpt
	if(!function_exists('blu_excerpt_read_more_link')){
		function blu_excerpt_read_more_link($output) {
			if( !is_single() ){
		    	global $post;

		    	if( !bl_utilities::get_option('bl_show_continue_reading') ){
		    		return $output;
		    	}else{
					return substr($output,0,-5) . '<br /><a class="moretag" href="'. get_permalink($post->ID) . '">' . __('Continue reading...', 'bluth') . '</a>';
		    	}
			}
		}
	}
	// Excerpt length
	if(!function_exists('blu_excerpt_length')){ 
		function blu_excerpt_length($length) {
			if(!isset($length)){ $length = 55; }
			return bl_utilities::get_option('bl_excerpt_length', $length);
		}
	}
	// Remove Empty P tags that WP generates
	if(!function_exists('blu_remove_empty_p')){
		function blu_remove_empty_p($content){
			$content = force_balance_tags($content);
			return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
		}
	}
	// Get gravatar URL
	if(!function_exists('blu_get_avatar_url')){
		function blu_get_avatar_url( $get_avatar ) {
		    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
		    return $matches[1];
		}
	}
	// Get the post image
	if(!function_exists('blu_get_post_image')){
		function blu_get_post_image( $post_id, $size = 'small', $author_fallback = true, $thumbnail_id = false ) {
			
			// get thumbnail id if not present
			if($thumbnail_id){ return wp_get_attachment_image_src( $thumbnail_id, $size ); }
			// if there's a custom thumbnail present then always fetch that if this is a thumbnail image
			$custom_thumbnail = get_post_meta( $post_id, 'bluth_custom_thumbnail', true);

			if(isset($custom_thumbnail['gallery_src']) and !empty($custom_thumbnail['gallery_src']) and ( $size == 'small' || $size == 'thumbnail' || $size == 'mini' || $size == 'share' )){
				$custom_thumbnail = wp_get_attachment_image_src( $custom_thumbnail['gallery_id'], $size );
				return $custom_thumbnail[0];
			}

			// if the post has a featured image, always display that
			$thumb_id = get_post_thumbnail_id( $post_id );

			$thumb_url = wp_get_attachment_image_src( $thumb_id, $size, false );
			if($thumb_url[0]){
				return $thumb_url[0];
			}

			if(has_post_format('gallery', $post_id)){
				// if it's a gallery post and doesn't have a featured image, then display the first image in the gallery
				$images = get_post_meta( $post_id, 'blu_gallery', true );
				if(!empty($images[0]['gallery_src'])){
					$first_gallery_image = wp_get_attachment_image_src( $images[0]['gallery_id'], $size );
					return $first_gallery_image[0];
				}
			}else if ( $images = get_children(array('post_parent' =>  $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image' ))){ 
				// else display the first image in the post
				$image = current($images);
				$image = wp_get_attachment_image_src($image->ID, $size);
				return $image[0];
			}else if($first_image = blu_catch_that_image()){
				// else try again to get the first image in the post
				return $first_image;
			}else if( $video_image = blu_get_post_video_thumbnail( $post_id )){
				return $video_image;
			}else if( $author_fallback ){
				// if it can't find anything and the author fallback is enabled then display the authors image
				return blu_get_avatar_url( get_avatar( get_the_author_meta( 'ID' ) , $size ));
			}else{
				return false;
			} 
		}
	}
	// Get the first image
	if(!function_exists('blu_catch_that_image')){
		function blu_catch_that_image() {
			global $post, $posts;
			$first_img = '';
			ob_start();
			ob_end_clean();
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
			$first_img = isset($matches[1][0]) ? $matches[1][0] : false;

			if(empty($first_img))
				return false;

			return $first_img;
		}
	}
	// Get the video image
	if(!function_exists('blu_get_post_video_thumbnail')){
		function blu_get_post_video_thumbnail( $post_id, $size = 'hqdefault' ) {
			$video_url = get_post_meta( $post_id, 'blu_video_url', true );
			if($video_url){

				$video_url = html_entity_decode($video_url);
				// get image form video url
				$url = $video_url;
				$urls = parse_url($url);
			   //expect url is http://youtu.be/abcd, where abcd is video iD
			   if ($urls['host'] == 'youtu.be') : 
			       $imgPath = ltrim($urls['path'],'/');
			   //expect  url is http://www.youtube.com/embed/abcd
			   elseif (strpos($urls['path'],'embed') == 1) : 
			       $imgPath = end(explode('/',$urls['path']));
			    //expect url is abcd only
			   elseif (strpos($url,'/') === false):
			       $imgPath = $url;
			   //expect url is http://www.youtube.com/watch?v=abcd
			   else :
			       parse_str($urls['query']);
			       $imgPath = $v;
			   endif;

			   return 'http://img.youtube.com/vi/'.$imgPath.'/'.$size.'.jpg'; 
			}else{
				return false;
			}
		}
	}
	// Get the post icon
	if(!function_exists('blu_get_post_icon')){
		function blu_get_post_icon( $post_id ) {
			$post_format = (get_post_format( $post_id )) ? get_post_format( $post_id ) : 'standard'; 	

			$icon = of_get_option($post_format.'_icon', false);
			$icon_default = array('standard' => 'icon-calendar-3', 'audio' => 'icon-volume-up', 'video' => 'icon-videocam','quote' => 'icon-quote-left', 'link' => 'icon-link', 'image' => 'icon-picture-1', 'gallery' => 'icon-picture');
			$icon = ($icon !== false) ? $icon : $icon_default[$post_format];

			return $icon;
		}
	}
	// Add Custom Admin Scripts
	if(!function_exists('blu_admin_scripts')){
		function blu_admin_scripts() {

			// ONLY LOAD THIS ON MENU PAGE
			wp_enqueue_style('thickbox');
			wp_enqueue_script('thickbox');
			echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/assets/css/font-awesome.min.css">';
			// echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/assets/css/fontello.css">';

		  	wp_enqueue_media();
		  	wp_enqueue_script('hrw',  get_template_directory_uri() . '/assets/js/admin-script.js', array( 'jquery' ), NANO_VERSION, true);
		}
	}
	// Set post view count
	if(!function_exists('blu_set_post_views')){
		function blu_set_post_views($postID) {
		    $count_key = 'blu_post_views_count';
		    $count = get_post_meta($postID, $count_key, true);
		    if($count==''){
		        $count = 0;
		        delete_post_meta($postID, $count_key);
		        add_post_meta($postID, $count_key, '0');
		    }else{
		        $count++;
		        update_post_meta($postID, $count_key, $count);
		    }
		}
	}
	// Get post view count
	if(!function_exists('blu_get_post_views')){
		function blu_get_post_views($postID){
			$count_key = 'blu_post_views_count';
			$count = get_post_meta($postID, $count_key, true);
			if($count==''){
			    delete_post_meta($postID, $count_key);
			    add_post_meta($postID, $count_key, '0');
			    return '0';
			}
			return $count;
		}
	}
	// Split text and put bold in the last word
	if(!function_exists('blu_boldsplit')){
		function blu_boldsplit($string){
			$wordarray = explode(' ', $string);
			if (count($wordarray) > 1 ) {
			  $wordarray[count($wordarray)-1] = '<strong class="blu_bold">'.($wordarray[count($wordarray)-1]).'</strong>';
			  $string = implode(' ', $wordarray); 
			}  

			return '<span class="blu_boldsplit">'.$string.'</span>';
		}
	}
	// Useful truncate function
	if(!function_exists('blu_truncate')){
		function blu_truncate($string, $limit, $break=".", $pad="..."){
		  	if(strlen($string) <= $limit) return $string;
		  		if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		    		if($breakpoint < strlen($string) - 1) {
		      		$string = substr($string, 0, $breakpoint) . $pad;
				}
		  	}
		 	return $string;
		}
	}


	#
	# 	MAILCHIMP
	#
	
	// MailChimp Widget
	if(!function_exists('blu_ajax_mailchimp')){
		function blu_ajax_mailchimp(){  
			$options = get_option('widget_bl_newsletter');
			$options = current($options);

			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_POST['email'])) {
				echo json_encode(array("error" => __('Email address is invalid','bluth'))); 
				die();
			}
			else if(!isset($options['list_id'])){
				echo json_encode(array("error" => "No mailing list selected"));
				 die();
			}
			else if(!isset($options['api_key'])){
				echo json_encode(array("error" => "API key not defined")); 
				die();
			}
			else if(!isset($_POST['email'])){ 
				echo json_encode(array("error" => __('No email address provided','bluth'))); 
				die();
			} 

			require_once(get_template_directory().'/inc/mailchimp/MCAPI.class.php');

			$api = new MCAPI($options['api_key']);

			$list_id = $options['list_id'];

			if($api->listSubscribe($list_id, $_POST['email'], '') === true) {
				echo json_encode(array("status" => 'ok'));
			}else{
				echo json_encode(array("error" => 'Error: ' . $api->errorMessage));
			}
		    die();
		} 
	} 

	#
	# 	SOCIAL COUNTER WIDGET
	#
	if(!function_exists('blu_get_url')){
		function blu_get_url($url){
	        $bl_results = @wp_remote_retrieve_body(@wp_remote_get($url, array('timeout' => 18 , 'sslverify' => false)));
	        return $bl_results;
    	}
    }
	if(!function_exists('blu_get_json')){
		function blu_get_json($url){
	        $bl_json = @json_decode(blu_get_url($url), true);
	        return $bl_json;
    	}
	}
	if(!function_exists('blu_get_social_counter')){
		function blu_get_social_counter($social_service) {

			$return_array = array();

			// Cache the results if they haven't been cached
			if(($cache = get_transient('bl_social_counter')) === false){
	
				foreach ($social_service as $site => $user_id) {
		
					$bl_counter = 0;

					switch($site){
						case 'facebook':
							$bl_data = blu_get_json("http://graph.facebook.com/$user_id");
		                    if ( is_array($bl_data) and !empty($bl_data['likes']) ) {
		                        $return_array['facebook'] = $bl_data['likes'];
		                    }
						break;
						case 'twitter':
							if(!class_exists('TwitterApiClient')){
								require_once('twitter-api.php');
								$Client = new TwitterApiClient;
								$Client->set_oauth (YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, SOME_ACCESS_KEY, SOME_ACCESS_SECRET);
								try {
			                        $path = 'users/show';
			                        $args = array ('screen_name' => $user_id);
			                        $bl_data = @$Client->call( $path, $args, 'GET' );
			                        if (!empty($bl_data['followers_count'])) {
			                            $return_array['twitter'] = $bl_data['followers_count'];
			                        }
			                    }
			                    catch( TwitterApiException $Ex ){ return $Ex; }
							}
						break;
		                case 'google-plus':
		                    $bl_data = blu_get_json("https://www.googleapis.com/plus/v1/people/$user_id?key=AIzaSyCfgXt3OctK-8566-5oinbCO1vRMGzsTy8");

		                    if (!empty($bl_data['plusOneCount'])) {
		                        $return_array['google-plus'] = $bl_data['plusOneCount'];
		                    }
		                    else if (!empty($bl_data['circledByCount'])) {
		                        $return_array['google-plus'] = $bl_data['circledByCount'];
		                    }

		                break;
		                case 'instagram':
		                    $bl_data = blu_get_url("http://instagram.com/$user_id#");
		                    $pattern = "/followed_by\":(.*?),\"follows\":/";
		                    preg_match($pattern, $bl_data, $matches);
		                    if (!empty($matches[1])) {
		                        $return_array['instagram'] = $matches[1];
		                    }
		                break;
					}
				}
		        set_transient( 'bl_social_counter', $return_array, 60 * 60 * 3);
			}else{
				$return_array = $cache;
			}

			return $return_array;

		}
	}

	#
	#	REGISTERED REQUIRED PLUGINS
	#
	if(!function_exists('blu_register_required_plugins')){
		function blu_register_required_plugins() {
			$plugins = array(
				array(
					'name'     				=> 'Regenerate Thumbnails', // The plugin name
					'slug'     				=> 'force-regenerate-thumbnails', // The plugin slug (typically the folder name)
					'source'   				=> 'http://wordpress.org/plugins/force-regenerate-thumbnails/', //get_template_directory_uri() . '/inc/plugins/cf-post-formats.zip', // The plugin source
					'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
					'version' 				=> '2.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url' 			=> 'http://wordpress.org/plugins/force-regenerate-thumbnails/', // If set, overrides default API URL and points to an external URL
				),
			);

			/**
			 * Array of configuration settings. Amend each line as needed.
			 * If you want the default strings to be available under your own theme domain,
			 * leave the strings uncommented.
			 * Some of the strings are added into a sprintf, so see the comments at the
			 * end of each line for what each argument will be.
			 */
			$config = array(
				'domain'       		=> 'nano',         			// Text domain - likely want to be the same as your theme.
				'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
				'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
				'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
				'menu'         		=> 'install-required-plugins', 	// Menu slug
				'has_notices'      	=> true,                        // Show admin notices or not
				'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
				'message' 			=> '',							// Message to output right before the plugins table
				'strings'      		=> array(
					'page_title'                       			=> __( 'Install Required Plugins', 'bluth' ),
					'menu_title'                       			=> __( 'Install Plugins', 'bluth' ),
					'installing'                       			=> __( 'Installing Plugin: %s', 'bluth' ), // %1$s = plugin name
					'oops'                             			=> __( 'Something went wrong with the plugin API.', 'bluth' ),
					'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
					'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
					'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
					'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
					'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
					'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
					'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
					'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
					'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
					'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
					'return'                           			=> __( 'Return to Required Plugins Installer', 'bluth' ),
					'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'bluth' ),
					'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'bluth' ), // %1$s = dashboard link
					'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
				)
			);
			tgmpa($plugins, $config);
		}
	}

	#
	# 	NOTIFY TO SAVE CUSTOMIZER
	#
	if(!function_exists('blu_admin_notices')){
		function blu_admin_notices(){
	        $theme_options = get_option(BL_THEME_OPTIONS);
	        if(!$theme_options) {
			    echo '<div class="updated">
			       <h3>Notice:</h3>
			       <p><strong>Customize your theme and save it in the <a href="customize.php">Customizer!</a> to ensure everything is working properly</strong></p>
			       <p>We hope you enjoy ' . BL_THEME_NAME . '!</p>
			    </div>';
			}
		}
	}
	add_action('admin_notices', 'blu_admin_notices');

	// Hooks/Filters
	add_action( 'after_setup_theme', 'blu_theme_setup' );	// ----------------------- Custom setup
	add_action( 'wp_head', 'blu_header_assets' ); // --------------------------------- Header hook
	add_filter( 'wp_generate_attachment_metadata', 'blu_retina_support', 10, 2 ); // - Retina Support
	add_filter( 'delete_attachment', 'blu_delete_retina_support_images' ); // -------- Retina Support (Delete image)
	add_filter( 'excerpt_more', 'blu_excerpt_more' ); // ----------------------------- Add an Excerpt button
	add_filter( 'the_excerpt', 'blu_excerpt_read_more_link' ); // -------------------- Manual Excerpt
	add_filter( 'excerpt_length', 'blu_excerpt_length' ); // ------------------------- Custom Excerpt Length
	add_filter( 'get_archives_link', 'blu_archive_count_span' ); // ------------------ Add span tag around archives post count
	add_filter( 'wp_list_categories', 'blu_cat_count_span' ); // --------------------- Add span tag around categories post count
	add_filter( 'image_send_to_editor','blu_lightbox_class',10,8 ); // --------------- Add lightbox classes to images in posts
	add_filter( 'the_content', 'blu_remove_empty_p', 20, 1 ); // --------------------- Remove Empty P tags that WP generates
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

	// AJAX
	add_action( 'wp_ajax_blu_ajax_comment_score', 'blu_ajax_comment_score' );
	add_action( 'wp_ajax_nopriv_blu_ajax_comment_score', 'blu_ajax_comment_score' );  
	add_action( 'wp_ajax_blu_next_post', 'blu_next_post' );
	add_action( 'wp_ajax_nopriv_blu_next_post', 'blu_next_post' );  
	add_action( 'wp_ajax_blu_ajax_mailchimp', 'blu_ajax_mailchimp' );
	add_action( 'wp_ajax_nopriv_blu_ajax_mailchimp', 'blu_ajax_mailchimp' );  