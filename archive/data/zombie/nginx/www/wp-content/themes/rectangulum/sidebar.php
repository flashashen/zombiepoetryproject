<?php
/**
 * @package Rectangulum
 */
?>
	<div id="sidebar" class="content-left widget-area" role="complementary">

<?php if ( is_single() ) : ?>

	<?php if ( has_post_thumbnail() ) { ?><!--Header Image Post-->
		<div class="excerpt">
	<?php if ( has_excerpt() ) : ?>
		<?php the_excerpt(); ?>
	<?php endif; //has_excerpt() ?>	
		</div>
	<?php } ?>

	<div id="author" class="author-area clearfix">

<?php
$avatar = get_theme_mod( 'avatar_upload' );
if( !empty($avatar) ) { ?>
	<img src="<?php echo esc_url( get_theme_mod( 'avatar_upload' ) ); ?>" style="height:120px;" />
<?php } else { ?>
	<?php echo get_avatar( get_the_author_meta('ID'), 720 ); ?>
<?php } ?>

		<div class="author-meta">
			<p><?php _e( 'Posted by ', 'rectangulum'); ?><?php the_author_posts_link(); ?></p>
			<p><?php the_author_meta('description'); ?></p>
		</div>

	</div><!-- #author -->

<?php endif; //  is_single()  ?>

		<?php do_action( 'before_sidebar' ); ?>

		<?php if ( ! dynamic_sidebar( 'sidebar-blog' ) ) : ?>

			<aside class="widget">
				<h1 class="widget-title"><?php _e( 'Meta', 'typal' ); ?></h1>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // ! dynamic_sidebar ?>
	</div><!-- #sidebar -->
