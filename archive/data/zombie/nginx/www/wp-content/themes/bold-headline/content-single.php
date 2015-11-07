<?php
/**
 * @package Bold Headline
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-summary">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>		
		</header><!-- .entry-header -->
		
		<?php if (has_post_thumbnail()) { 
			the_post_thumbnail( 'bold-headline-image-post', array( 'class' => 'aligncenter' ) );
		} ?>
		
		<?php the_content( __( 'Read More <span class="meta-nav">&rarr;</span>', 'bold_headline' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'bold_headline' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-summary -->

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php bold_headline_posted_on_and_by(); ?>
			
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'bold_headline' ) );
					if ( $categories_list && bold_headline_categorized_blog() ) :
				?>
				<span class="cat-links genericon">
					<?php printf( __( ' %1$s', 'bold_headline' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'bold_headline' ) );
					if ( $tags_list ) :
				?>
				<span class="tags-links genericon">
					<?php printf( __( ' %1$s', 'bold_headline' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
	
			<span class="comments-link genericon"><?php comments_popup_link( __( 'Leave a comment', 'bold_headline' ), __( '1 Comment', 'bold_headline' ), __( '% Comments', 'bold_headline' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'bold_headline' ), '<span class="edit-link genericon">', '</span>' ); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

</article><!-- #post-## -->
