<?php
/**
 * @package Rectangulum
 */

get_header(); ?>


	<div id="content" class="site-content clearfix">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php get_sidebar(); ?>

	</div><!-- #content -->


<?php get_footer(); ?>