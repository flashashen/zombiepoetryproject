<div id="sidebar-left" class="sidebar">
<?php if ( !dynamic_sidebar('sidebar-left') ) : ?>
	<h4><?php _e('Categories', 'prpin'); ?></h4>
	<ul>
		<?php wp_list_categories('title_li='); ?>
	</ul>
<?php endif ?>
</div>