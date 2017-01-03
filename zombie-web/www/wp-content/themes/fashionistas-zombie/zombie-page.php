<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package aThemes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>

<!--	<header class="entry-header">-->
<!--		<h1 class="entry-title">--><?php //the_title(); ?><!--</h1>-->
<!--	</header><!-- .entry-header -->-->


	<header class="entry-header">
		<h2 class="entry-title-zombie"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php athemes_posted_on(); ?>

				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
					<span class="comments-link"> <?php comments_popup_link( __( 'Leave a Comment', 'athemes' ), __( '1 Comment', 'athemes' ), __( '% Comments', 'athemes' ) ); ?></span>
				<?php endif; ?>
				<!-- .entry-meta --></div>
		<?php endif; ?>
		<!-- .entry-header --></header>


	<?php if ( (has_post_thumbnail()) && ( get_theme_mod( 'athemes_page_img' )) ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>	
	<?php endif; ?>


	<div class="clearfix entry-content container-fluid">
			<div class="row-fluid">
				<div class="span6">
					<?php the_content(); ?>
				</div>
				<div class="span6">
					<?php get_post_custom(); ?>
				</div>
			</div>
		</div>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'athemes' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->


</article><!-- #post-## -->
