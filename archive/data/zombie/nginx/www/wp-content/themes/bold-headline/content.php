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
			
			<?php if (has_post_thumbnail()) { ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignright thumb' ) ); ?></a>
			<?php } ?>
			
			<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<div class="entry-meta">
		<?php bold_headline_posted_on(); ?>
			
		<?php edit_post_link( __( 'Edit', 'bold_headline' ), '<span class="edit-link genericon">', '</span>' ); ?>
	</div><!-- .entry-meta -->


</article><!-- #post-## -->
