<?php
/**
 * Setup the WordPress core custom header feature.
 * @package Rectangulum
 */

if ( ! function_exists( 'rectangulum_admin_header_style' ) ) :

function rectangulum_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			background: #fff;
			background-size:100%;
			max-height: 350px;
		}
		#headimg img {
			display: block;
			margin: 0 auto;
			width: 100%;
			height: auto;
			max-height: 350px;
		}
	</style>
<?php
}
endif; // rectangulum_admin_header_style

if ( ! function_exists( 'rectangulum_admin_header_image' ) ) :

function rectangulum_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" />
		<?php endif; ?>
	</div>
<?php
}
endif; // rectangulum_admin_header_image
