<form action="<?php echo home_url( '/' ); ?>" method="get" class="searchform" role="search">
    <fieldset>
    	<i class="fa fa-search"></i>
    	<input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="<?php _e('Search..', 'bluth'); ?>"/>
    </fieldset>
</form>