<?php
/**
 * The template used for displaying page content
 *
 * @package so-simple-75
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>

	<header class="entry-header">
		<?php if( has_post_thumbnail() ) : ?>
			<div class="single-featured-image">
				<?php the_post_thumbnail('featured', array( 'class' => 'featured-thumb' )); ?>
			</div>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<p class="page-links">' . __( 'Pages:', 'so-simple-75' ),
			'after'  => '</p>',
		) );
		?>
	</div><!-- .entry-content -->

</article>