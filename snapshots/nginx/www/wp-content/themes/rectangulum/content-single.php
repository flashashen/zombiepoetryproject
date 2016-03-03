<?php
/**
 * @package Rectangulum
 */
?>

<?php if ( has_post_thumbnail() ) { ?>
	<div class="post-thumb">
	<?php the_post_thumbnail( 'rectangulum-featured' ); ?>
	</div>
<?php } ?>

<div class="content-right" role="main">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header clearfix">
		<h1 class="entry-title"><?php the_title(); ?></h1>

	<div class="entry-format">
<time datetime="<?php the_time('Y-m-d'); ?>"><span class="date updated"><?php the_time(get_option('date_format')); ?></span></time>
<span class="author vcard screen-reader-text"><span class="url fn n"><?php the_author_posts_link(); ?></span></span>

		<?php if( get_post_format()!='' ) : ?>
<a href="<?php echo esc_url( get_post_format_link( get_post_format() ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a>
		<?php endif;//get_post_format() ?>
	</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'rectangulum' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			$category_list = get_the_category_list( __( ', ', 'rectangulum' ) );
			$tag_list = get_the_tag_list( '', __( ', ', 'rectangulum' ) );

			if ( ! rectangulum_categorized_blog() ) {
				if ( '' != $tag_list ) {
					$meta_text = __( '<p>Tagged %2$s.</p>', 'rectangulum' );
				} else {
					$meta_text = '';
				}

			} else {
				if ( '' != $tag_list ) {
					$meta_text = __( 'Posted in %1$s and tagged %2$s.', 'rectangulum' );
				} else {
					$meta_text = __( 'Posted in %1$s.', 'rectangulum' );
				}

			} // end check for categories

			printf(
				$meta_text,
				$category_list,
				$tag_list
			);
		?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->

<?php rectangulum_content_nav( 'nav-below' ); ?>

	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() )
			comments_template();
	?>

</div><!-- .content-right -->