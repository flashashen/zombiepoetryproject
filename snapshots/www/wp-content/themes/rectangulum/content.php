<?php
/**
 * @package Rectangulum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php if ( has_post_thumbnail() && !has_post_format( array('aside', 'quote', 'link', 'image', 'gallery', 'video', 'audio')) ) : ?>

		<figure class="featured-image">

			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( 'rectangulum-featured-small' ); ?>
			</a>

		</figure>

	<?php endif; ?>

	<header class="entry-header" <?php if ( !has_post_thumbnail() ) : ?>style="padding: 0;"<?php endif; ?>>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>

		<div class="entry-meta">

			<?php rectangulum_posted_on(); ?>

			<?php $comments = get_comments_number();

			if ( $comments > 0 ) : ?>

				 | <a href="<?php the_permalink(); ?>#comments">

				<?php printf( _nx( '1 Comment', '%1$s Comments', $comments, 'comments title', 'rectangulum' ), number_format_i18n( $comments ) ); ?>

				 </a>

			<?php endif; ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-summary" <?php if ( !has_post_thumbnail() ) : ?>style="padding: 0;"<?php endif; ?>>

<?php if ( has_post_format( array('aside', 'quote', 'link', 'image', 'gallery', 'video', 'audio')) ) : ?>
	<?php the_content(); ?>
<?php else ://post_format() ?>
	<?php the_excerpt(); ?>
	<a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php _e('Continue reading <span class="meta-nav">&rarr;</span>', 'rectangulum'); ?></a>
<?php endif; //post_format() ?>

	</div><!-- .entry-summary -->

</article><!-- #post-<?php the_ID(); ?> -->