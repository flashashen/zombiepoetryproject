<?php
/**
 * @package Rectangulum
 */

get_header(); ?>

	<div id="content" class="site-content">

		<div class="content-right" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'rectangulum' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'rectangulum' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .entry-content -->
			</article><!-- #post-0 .post .error404 .not-found -->

	<div class="grid2 clearfix">
		<div class="col widget-area">
				<h2><?php _e( 'Pages', 'rectangulum' ); ?></h2>
				<ul>
				<?php
					wp_list_pages( array(
						'title_li'   => ''
					) );
				?>
				</ul>
		</div>
		<div class="col widget-area">
				<h2><?php _e( 'Categories', 'rectangulum' ); ?></h2>
				<ul>
				<?php
					wp_list_categories( array(
						'order'      => 'DESC',
						'show_count' => 1,
						'title_li'   => ''
					) );
				?>
				</ul>
		</div>
	</div><!--.grid2-->

		</div><!-- .content-right -->

		<div class="content-left widget-area">

			<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

		</div><!-- .content-left .widget-area -->

	</div><!-- #content -->

<?php get_footer(); ?>