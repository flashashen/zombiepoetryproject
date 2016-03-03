<form method="get" action="<?php echo home_url(); ?>/" class="form-search">
	<input type="text" value="<?php the_search_query(); ?>" name="s" class="input-medium" />
	<input class="btn" type="submit" value="<?php _e('Search', 'prpin'); ?>" />
</form>