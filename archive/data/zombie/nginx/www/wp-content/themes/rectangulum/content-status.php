<?php
/**
 * The template for Status post format
 * @package Rectangulum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<div class="status">
<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 48 ); ?></a>
		</div><!--.status-->
<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'rectangulum' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	<footer class="entry-meta" style="text-align: right;margin:0; padding:0;">
			<?php if( get_post_format()!='' ) : ?>
<a href="<?php echo esc_url( get_post_format_link( get_post_format() ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a>
<?php endif;//get_post_format() ?>
                                <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'rectangulum' ), __( '1 Comment', 'rectangulum' ), __( 'Comments: %', 'rectangulum' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'rectangulum' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
