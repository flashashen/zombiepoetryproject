<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Bold Headline
 */

get_header(); ?>

<div id="primary" class="content-area clearfix">
	<div id="content" class="site-content" role="main">
		<article class="hentry post clearfix error404 not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'bold_headline' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'bold_headline' ); ?></p>

				<?php get_search_form(); ?>

			</div><!-- .entry-content -->
		</article><!-- #post-0 .post .error404 .not-found -->

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>