<?php
/**
 * The template for displaying all pages.
 *
 * @package so-simple-75
 */

get_header(); ?>

<main id="main" class="site-main" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'page' ); ?>

	<?php endwhile; ?>

</main><!-- #main -->

<?php get_footer(); ?>