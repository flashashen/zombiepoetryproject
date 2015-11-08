<?php
/**
 * The Sidebar containing the main widget areas will appear as a footer if widgets are set.
 *
 * @package Bold Headline
 */
?>

<?php
	/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	if (   ! is_active_sidebar( 'footer-left'  )
		&& ! is_active_sidebar( 'footer-center' )
		&& ! is_active_sidebar( 'footer-right'  )
	)
		return;
	// If we get this far, we have widgets. Let do this.
?>

	<div id="secondary" class="clearfix" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<div id="first" class="widget-area">
		<?php if ( is_active_sidebar( 'footer-left' ) ) : ?>
			<?php dynamic_sidebar( 'footer-left' ); ?>
		<?php endif; ?>
		</div>
		
		<div id="second" class="widget-area middle">
		<?php if ( is_active_sidebar( 'footer-center' ) ) : ?>
			<?php dynamic_sidebar( 'footer-center' ); ?>
		<?php endif; ?>
		</div>
		
		<div id="third" class="widget-area">
		<?php if ( is_active_sidebar( 'footer-right' ) ) : ?>
			<?php dynamic_sidebar( 'footer-right' ); ?>
		<?php endif; ?>
		</div>
	</div><!-- #secondary -->