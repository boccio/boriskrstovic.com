

<?php 
		// close the primary container 
		// if it hasn't already been closed because of the comments
		// var_dump( have_comments() );
		// var_dump( comments_open() );
		if ( (!is_single() and !is_page() ) or ( ( is_single() or is_page() ) and !have_comments() and ( !comments_open() or !bl_utilities::get_option('bl_page_comments') ) ) ){ ?>
			</div> <!-- #main -->
			</div> <!-- #primary --> <?php
		}

		//get theme options
		$footer_text = of_get_option('footer_text', '' ); ?>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="row" id="footer-body">
				<?php dynamic_sidebar('footer-widgets'); ?>
			</div><?php
			if(bl_utilities::get_option('bl_footer_text', false)){?>
				<div id="footer-bottom"> <?php 
					echo html_entity_decode(str_replace("{year}", date('Y'), bl_utilities::get_option('bl_footer_text'))); ?>
				</div><?php
			} ?>
		</footer><!-- #colophon .site-footer -->
	</div><!-- #main --> 
</div><!-- #page --> <?php 

// Only show the customizer if it's the live demo
if(defined('BLUTHEMES_DEMO')){
	get_template_part( 'demo/customizer'); 
} 
wp_footer(); ?>
</body>
</html>