<?php if (have_comments()) :
	
	$comment_count = 0;

	$pings_and_tracks = 0;

	foreach ( get_approved_comments( $id ) as $comment ) {
		
		if ( $comment->comment_type === '' ) : $comment_count++;
		else : $pings_and_tracks++;
		endif; }

	if ($comment_count > 0) : ?>

		<div id="comments" class="the_comments">
			<h3 class="post_title"><?php _e('Comments', 'localize_adventure'); ?></h3>
			<ul class="commentlist"><?php wp_list_comments(array('avatar_size' => 100, 'style' => 'li', 'type' => 'comment')); ?></ul>
		</div>

	<?php endif;

	if ($pings_and_tracks > 0) : ?>

        <div class="the_comments">
            <h3 class="post_title"><?php _e('Pingbacks &amp; Trackbacks', 'localize_adventure'); ?></h3>
            <ul class="commentlist"><?php wp_list_comments(array('avatar_size' => 100, 'style' => 'li', 'type' => 'pings')); ?></ul>
        </div>
	<?php endif;
    
endif;
        
if (comments_open()) :

   comment_form();

endif;

if ( have_comments() || comments_open() ) : ?>

    <div class="stars_and_bars">
        <span class="left"><?php paginate_comments_links(); ?></span>
        <span class="right"></span>
    </div><?php 

endif; ?>