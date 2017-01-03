<?php

/*
Template Name: IncidentsTemplateTest
*/

get_header();
?>

	<div id="incidents-primary" class="content-area">
		<div id="incidents-content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

			<!-- #content --></div>
		<!-- #primary --></div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>