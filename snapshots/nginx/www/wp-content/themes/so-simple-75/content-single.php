<?php
/**
 * The template part for displaying content for individual posts.
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
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<span class="entry-date"><?php sosimpleposted_on(); ?></span>
		
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<p class="page-links">' . __( 'Pages:', 'so-simple-75' ),
			'after'  => '</p>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		
		<?php do_action( 'sosimpleentry_meta_items' ); ?>

		<?php
			// translators: used between list items, there is a space after the comma
			$category_list = get_the_category_list( __( ', ', 'so-simple-75' ) );

			// translators: used between list items, there is a space after the comma
			$tag_list = get_the_tag_list( '', __( ', ', 'so-simple-75' ) );
			
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'so-simple-75' );
			} else {
				$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'so-simple-75' );
			}

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'so-simple-75' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article>