<?php

/*
Template Name: TestZombieTemplate
*/

get_header(); ?>


	<div id="primary" class="content-area container">
		<div id="content" class="site-content content-area" role="main">


			<?php

			$query = array (
				'posts_per_page' => 20,
				'meta_key' => 'zombie-artifacts'
			);
			$queryObject = new WP_Query($query);
			// The Loop...
			if ($queryObject->have_posts()) {
				while ($queryObject->have_posts()) {
					$queryObject->the_post();

					?>

					<header class="entry-header">
						<h1 class="entry-title"><?php echo $queryObject->post->post_date; echo ". &nbsp &nbsp"; the_title() ?></h1>

<!--						--><?php //if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
<!--							<span class="comments-link"> --><?php //comments_popup_link( __( 'Leave a Comment', 'athemes' ), __( '1 Comment', 'athemes' ), __( '% Comments', 'athemes' ) ); ?><!--</span>-->
<!--						--><?php //endif; ?>


					<div class="entry-meta">
						<?php echo get_post_meta( $queryObject->post->ID, 'user_submit_name', 1 ); ?>
					</div>

					</header>


					<?php the_content(); ?>


				<?php
				}
			}
		?>



		<!-- #content --></div>
	<!-- #primary --></div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>