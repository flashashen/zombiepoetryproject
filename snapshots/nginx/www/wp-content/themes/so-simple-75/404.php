<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package so-simple-75
 */

get_header(); ?>

<main id="main" class="site-main" role="main">

	<div class="entry-content">

		<h1><?php _e('404', 'balanced'); ?></h1>

		<p><?php _e( 'It looks like the page you&rsquo;re looking for doesn&rsquo;t exist. Perhaps a quick look through these pages will help you find what you&rsquo;re looking for:', 'balanced' ); ?></p>
		
		<?php 
			wp_nav_menu( 
				array( 
					'theme_location' => 'main_menu',
					'container_class' => 'entry-content-menu',
					'depth' => 1
				) 
			); 
		?>

	</div><!-- .page-content -->

</main><!-- #main -->

<?php get_footer(); ?>