<?php
/**
 * @package Rectangulum
 */
get_header(); ?>

<!-- Heading Tagline -->
		<?php $home_image = get_header_image(); ?>
<div id="home-tagline" style="background: <?php echo get_theme_mod( 'home_tagline_bgcolor', '#e8e09d' ); ?><?php if( !empty($home_image) ) { ?> url(<?php echo esc_url( $home_image );?>); background-position: 50% 50%; background-size:100%<?php } ?>;">
	<div class="tagline-txt">
		<?php echo get_theme_mod( 'home_tagline', '<h1>Home Tagline</h1>' ); ?>
	</div>
</div><!--#home-tagline-->
		
	<div id="content" class="site-content clearfix" role="main">

		<?php
		$sticky_posts = get_option('sticky_posts');

			if ( !empty( $sticky_posts ) ) :
			$args = array(
			    'post__in' => get_option('sticky_posts'),
				'post_status' => 'publish'
			);

			$sticky_query = new WP_Query( $args ); ?>

		<?php if ( $sticky_query->have_posts() ) : ?>

			<div class="flexslider sticky-posts clearfix">

				<ul class="slides">
				<?php /* Start the Loop */ ?>
				<?php while ( $sticky_query->have_posts() ) : $sticky_query->the_post(); ?>

					<li>
					<?php get_template_part( 'content', 'sticky' ); ?>
					</li>

				<?php endwhile; wp_reset_postdata(); ?>
				</ul><!-- .slides -->

			</div><!-- .flexslider .sticky-posts -->

		<?php endif; ?>

			<?php endif; //!empty ?>

		<?php

		$args = array(
		    'posts_per_page' => get_option('posts_per_page'),
		    'paged' => get_query_var('paged'),
		    'post__not_in' => get_option('sticky_posts'),
		    'post_status' => 'publish'
		);

		$wp_query = new WP_Query( $args ); ?>

		<?php get_template_part( 'content', 'blog' ); ?>

	</div><!-- #content -->

<?php get_footer(); ?>