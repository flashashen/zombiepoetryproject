<?php
/**
 * The template for displaying the footer.
 *
 * @package so-simple-75
 */
?>

		</div><!-- .site-content -->
	</div><!-- .site --> 
</div><!-- end .page-wrap -->

<footer class="site-footer">
	<div class="social-icons">
		<?php
			$social_icons = array('facebook', 'twitter', 'linkedin', 'instagram', 'pinterest');

			foreach($social_icons as $icon) {
				if($url = get_sosimpleoption($icon)) :
					echo '<a href="' . esc_url($url) . '"><svg class="icon icon-' . $icon . '" viewBox="0 0 32 32"><use xlink:href="#icon-' . $icon .'"></use></svg></a>';
				endif;
			}	
		?>
	</div> <!-- end .social-icons -->

	<nav class="footer-navigation">
		<?php 
			wp_nav_menu(
				array( 
					'theme_location' => 'footer_menu',
					'depth' => 1
				)
			); 
		?>
	</nav>

	<?php if ( get_sosimpleoption('copyright') ) : ?>
		<div class="copyright">
			<p>
				<?php printf( __( 'Copyright %s by', 'so-simple-75' ), date('Y') ); ?>
				<a href="<?php echo esc_url('http://press75.com', 'so-simple-75'); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'so-simple-75' ); ?>" rel="generator" target="_blank">
					<?php _e('Press 75', 'so-simple-75'); ?>
				</a>
				<?php printf( __( '&middot; So Simple - A %s Theme by %s', 'so-simple-75' ), 'WordPress', 'Press75' ); ?>
			</p>
		</div>
	<?php endif; ?>

</footer>

<?php wp_footer(); ?>

</body>
</html>