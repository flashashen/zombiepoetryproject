<?php
/**
 * @package Bold Headline
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-summary">
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'bold_headline' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>		
		</header><!-- .entry-header -->
		
		<?php the_excerpt(); ?>
		
	</div><!-- .entry-summary -->
	
	<div class="entry-meta">
		<?php bold_headline_posted_on(); ?>
	</div><!-- .entry-meta -->

</article><!-- #post-## -->
