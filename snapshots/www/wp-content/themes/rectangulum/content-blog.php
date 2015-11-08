<?php
/**
 * @package Rectangulum
 */

global $count; //posts number for left-right align
?>
		<div id="rectangulum-scroll">
<?php if ( have_posts() ) : ?>

	<?php /* Start the Loop */ ?>

	<?php while ( have_posts() ) : the_post(); ?>

<?php $count ++; 
//posts number for left-right align
?>

<div class="clearfix">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if ( !has_post_format( array('aside', 'quote', 'link', 'image', 'gallery', 'video', 'audio')) ) : ?>
	<figure class="sticky-post-image<?php if ( $count == 2 ) : echo '-2'; endif; ?>">

			<?php if ( has_post_thumbnail()) : ?>

				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'rectangulum-sticky' ); ?>
				</a>

			<?php endif; ?>

	</figure><!-- .sticky-post-image -->
<?php endif; //!has_post_format ?>

	<div class="sticky-post-content<?php if ( $count == 2 ) : echo '-2'; $count = 0; endif; ?><?php if ( has_post_format( array('aside', 'quote', 'link', 'image', 'gallery', 'video', 'audio')) ) { ?> formats<?php } ?>">

		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->

		<div class="entry-summary">
<?php if ( has_post_format( array('aside', 'quote', 'link', 'image', 'gallery', 'video', 'audio')) ) : ?>
	<?php the_content(); ?>
<?php else ://post_format() ?>
	<?php the_excerpt(); ?>
	<a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php _e('Continue reading <span class="meta-nav">&rarr;</span>', 'rectangulum'); ?></a>
<?php endif; //post_format() ?>
		</div><!-- .entry-summary -->


	</div><!-- .sticky-post-content -->

</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .clearfix -->

	<?php endwhile; ?>

<?php
	if ( class_exists( 'Jetpack' ) && ! Jetpack::is_module_active( 'infinite-scroll' ) ) {
rectangulum_content_nav( 'nav-below' );
	}
?>
	<?php //rectangulum_content_nav( 'nav-below' ); ?>

<?php endif; // have_posts() ?>

		</div><!-- #rectangulum-scroll-->