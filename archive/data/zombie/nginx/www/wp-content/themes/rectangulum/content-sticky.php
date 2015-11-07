<?php
/**
 * @package Rectangulum
 */

global $count; //sticky posts number for left-right float
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<figure class="sticky-post-image<?php if ( $count == 2 ) : echo '-2'; endif; ?>">

			<?php if ( has_post_thumbnail()) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'rectangulum-sticky' ); ?>
				</a>
			<?php endif; ?>

	</figure><!-- .sticky-post-image -->

	<div class="sticky-post-content<?php if ( $count == 2 ) : echo '-2'; $count = 0; endif; ?>">

		<header class="entry-header">
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php _e('Continue reading <span class="meta-nav">&rarr;</span>', 'rectangulum'); ?></a>
		</div><!-- .entry-summary -->


	</div><!-- .sticky-post-content -->

</article><!-- #post-<?php the_ID(); ?> -->