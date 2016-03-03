<?php
/**
 * @package Rectangulum
 */
$options = get_option( 'rectangulum_theme_settings' );
?>
	</div><!-- #main -->

	<footer id="colophon" class="site-footer clearfix" role="contentinfo">
		
	<div class="grid3 clearfix">
		<div class="col"><?php dynamic_sidebar('footer1'); ?></div>
		<div class="col"><?php dynamic_sidebar('footer2'); ?></div>
		<div class="col"><?php dynamic_sidebar('footer3'); ?></div>
	</div><!-- .grid3 -->

		<div class="site-info">
<?php if ( has_nav_menu( 'social' ) && $options['topbar_disable'] == 1 ) {
wp_nav_menu(
	array(
	'theme_location'  => 'social',
	'menu_id'         => 'menu-social',
	'depth'           => 1,
	'link_before'     => '<span class="screen-reader-text">',
	'link_after'      => '</span>',
	'fallback_cb'     => '',
	)
);
} ?>
<?php echo '&copy; '.date('Y').' - '; ?><span id="copyright-message"><?php echo get_theme_mod( 'rectangulum_footer_copyright_text', 'All Rights Reserved' ); ?></span>
<?php do_action( 'rectangulum_credits' ); ?>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>