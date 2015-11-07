<?php
/**
 * @package Rectangulum
 */
if ( post_password_required() )
	return;
?>

	<div id="comments" class="comments-area">
<?php
	if(  false === get_theme_mod( 'rectangulum_comment_toggle' ) ) {
		echo '<style type="text/css">' . "\n";
		echo '.toggle-comments::after {display:none;}' . "\n";
		echo '</style>' . "\n";
	}
?>

	<?php if ( have_comments() ) : ?>
		<div class="comments-header">
			
			<h2 class="comments-title"><a href="#" class="toggle-comments">
<?php _e('Comments: ', 'rectangulum'); ?> <?php comments_number(__('0', 'rectangulum'), __('1', 'rectangulum'), __('%', 'rectangulum') );?>
			</a></h2>

		</div>

		<div class="comments-wrapper" <?php if ( false === get_theme_mod( 'rectangulum_comment_toggle' ) ) : ?>style="display: block;"<?php endif;?>>

			<ol class="comment-list">
				<?php
					wp_list_comments( array( 'callback' => 'rectangulum_comment' ) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation-comment" role="navigation">
				<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'rectangulum' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'rectangulum' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'rectangulum' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
			<?php endif; //comment navigation ?>

		</div><!-- .comments-content -->

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'rectangulum' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->
