<?php
/**
 * The Template for displaying all single posts.
 *
 * @package so-simple-75
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

	        <?php
	        // If comments are open or we have at least one comment, load up the comment template
	        if ( comments_open() || '0' != get_comments_number() )
	            comments_template();
	        ?>

		<?php endwhile; ?>

	</main><!-- #main -->

<?php get_footer(); ?>