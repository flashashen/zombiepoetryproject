<?php
/**
 * Template Name: Child Grid
 *
 * @package Rectangulum
 */

get_header(); ?>

	<div id="content" class="site-content clearfix">

	<?php if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'rectangulum-featured' ); ?>

		<div class="excerpt">
	<?php if ( has_excerpt() ) : ?>
		<?php the_excerpt(); ?>
	<?php endif;?>	
		</div>

	<?php } //has_post_thumbnail() ?>

		<div class="content-full" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- .content-full -->

<!-- ChildGrid -->
	<?php
		$child_pages = new WP_Query( array(
			'post_type'      => 'page',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_parent'    => $post->ID,
			'posts_per_page' => 999,
			'no_found_rows'  => true,
		) );
	?>

	<?php if ( $child_pages->have_posts() ) : ?>

<div class="grid2 childpage">
				<?php while ( $child_pages->have_posts() ) : $child_pages->the_post(); ?>

					<div class="col">
						<?php get_template_part( 'content', 'childpage' ); ?>
					</div>

				<?php endwhile; ?>
<div class="clearfix"></div>
</div>

	<?php
		endif;
		wp_reset_postdata();
	?>
<!-- ChildGrid -->

	</div><!-- #content -->

<?php get_footer(); ?>