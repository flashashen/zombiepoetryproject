<?php get_header();

while ( have_posts() ) : the_post(); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('contents'); ?>>

    <h3 class="post_title"><?php if (get_theme_mod('display_date_setting') != 'off' ) : ?><time datetime="<?php the_time('Y-m-d H:i') ?>"><?php the_time('M jS') ?><br/><?php the_time('Y') ?></time><?php endif; ?><?php if ( get_the_title() ) { the_title();} else { _e('(No Title)', 'localize_adventure'); } ?></h3>

    <?php the_post_thumbnail('large_featured', array( 'class' => "featured_image"));

    the_content(); ?>

    <span class="tags">

        <?php wp_link_pages( array('before' => 'Pages: ', 'after' => '</br>') ); ?>

        Post Categories: <?php the_category(', '); the_tags('</br>Tags: ', ', ', ''); ?>

    </span>

</div>



<?php if ((get_theme_mod('previousnext_setting') != 'page') && (get_theme_mod('previousnext_setting') != 'neither')) : ?>

    <div class="stars_and_bars">
        <span class="left"><?php previous_post_link('%link', '&#8249; %title'); ?></span>
        <span class="right"><?php next_post_link('%link', '%title &#8250;'); ?></span>
    </div>

<?php else : ?>

    <div class="stars_and_bars"></div>

<?php endif;

if (!is_home() && (get_theme_mod('comments_setting') != 'none') && (get_theme_mod('comments_setting') != 'page')) :

    comments_template();

endif;

endwhile;

if (semperfi_is_sidebar_active('widget')) get_sidebar();

get_footer(); ?>