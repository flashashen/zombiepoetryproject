<?php get_header();

    if (have_posts()) :

        while (have_posts()) : the_post(); ?>

            <div id="post-<?php the_ID(); ?>" <?php if ( has_post_thumbnail()) : post_class('has_featured_image'); else : post_class(); endif;?>>

                <h3 class="post_title"><?php if (get_theme_mod('display_date_setting') != 'off' ) : ?><time datetime="<?php the_time('Y-m-d H:i') ?>"><?php the_time('M') ?><br/><?php the_time('jS') ?></time><?php endif; ?><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php if ( get_the_title() ) { the_title(); } else { _e('(No Title)', 'localize_adventure'); } ?></a></h3>
                
                <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail('large_featured', array( 'class' => "featured_image")); ?>
                </a>
                
                <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                    <?php the_excerpt(); ?>
                </a>

            </div>

        <?php endwhile;

    endif; ?>

<div class="stars_and_bars">  
    <span class="left"><?php next_posts_link( '&#8249; ' . __('Older Posts', 'localize_adventure') ); ?></span>
    <span class="right"><?php previous_posts_link( __('Newer Posts', 'localize_adventure') . '&#8250;' ); ?></span>
</div>

<?php if (semperfi_is_sidebar_active('widget')) get_sidebar();

get_footer(); ?>