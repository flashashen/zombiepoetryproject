<?php
/**
 * The template part for displaying content for individual posts.
 *
 * @package so-simple-75
 */
?>

<article id="item post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<p class="entry-date"><?php sosimpleposted_on(); ?></p>

		<?php if( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>">
			<div class="featured-image">
				<?php the_post_thumbnail('featured', array( 'class' => 'featured-thumb' )); ?>

				<div class="overlay-link">
					<svg class="link-icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
						 width="70px" height="70px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
						<path class="line-arrow" fill="none" fill-opacity="0" stroke="#ccc" stroke-width="0.5" stroke-miterlimit="1" d="M15.038,13.778c0.171,0.174,0.171,0.454,0,0.629l-0.627,0.63c-0.173,0.173-0.453,0.173-0.627,0l-4.381-4.406
						c-0.047-0.048-0.079-0.104-0.101-0.164c-0.898,0.661-2.002,1.054-3.2,1.054c-3.002,0-5.438-2.448-5.438-5.468
						s2.435-5.469,5.438-5.469s5.438,2.449,5.438,5.469c0,1.205-0.393,2.315-1.049,3.219c0.06,0.021,0.116,0.052,0.164,0.101
						L15.038,13.778z M6.104,2.407c-2.001,0-3.625,1.632-3.625,3.646c0,2.014,1.624,3.646,3.625,3.646c2.002,0,3.625-1.632,3.625-3.646
						C9.729,4.039,8.106,2.407,6.104,2.407z"/>
					</svg>
				</div>
			</div>
		</a>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-excerpt">
		<?php the_excerpt(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<p class="page-links">' . __( 'Pages:', 'so-simple-75' ),
			'after'  => '</p>',
		) );
		?>
	</div><!-- .entry-content -->
</article>
