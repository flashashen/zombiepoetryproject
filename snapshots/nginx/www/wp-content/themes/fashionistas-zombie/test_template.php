<?php

/*
Template Name: TestZombieTemplate
*/

get_header(); ?>




	<div id="primary" class="content-area container">
		<div id="content" class="site-content content-area" role="main">



<!--			--><?php
//				global $wpdb;
//					$posts = $wpdb->get_results("select * from wp_posts p, wp_postmeta m  where p.id = m.post_id and m.meta_key = 'zombie_text' order by p.id desc limit 5;");
//
//				echo "<table>";
//				foreach($options as $option){
//					echo "<tr>";
//					echo "<td>".$option->option_id."</td>";
//					echo "<td>".$option->option_name."</td>";
//					echo "<td>".$option->option_value."</td>";
//					echo "<td>".$option->autoload."</td>";
//					echo "</tr>";
//				}
//				echo "</table>";
//				?>


			<?php

			$query = array (
				'posts_per_page' => 20,
				'meta_key' => 'zombie_text'
			);
			$queryObject = new WP_Query($query);
			// The Loop...
			if ($queryObject->have_posts()) {
				while ($queryObject->have_posts()) {
					$queryObject->the_post();

					?>

<!--					<h2 id='zombie-post-title' class="entry-title">-->
<!--						<a href="--><?php //the_permalink(); ?><!--" rel="bookmark">-->
<!--							--><?php //echo $queryObject->post->post_date; echo ". &nbsp &nbsp"; the_title() ?>
<!--						</a>-->
<!--					</h2>-->

					<header class="entry-header">
						<h1 class="entry-title"><?php echo $queryObject->post->post_date; echo ". &nbsp &nbsp"; the_title() ?></h1>

					<div class="entry-meta">
<!--						-->

						<?php //athemes_posted_on();
							echo get_post_meta( $queryObject->post->ID, 'user_submit_name', 1 );
//							if (!isset($author) || trim($author)===''){
//								?>
<!--									<span class="comments-link">--><?php //echo $author; ?><!--</span>-->
<!--								--><?php
//							}
						?>

<!--						<span class="entry-date vcard">--><?php
//							$author = get_the_author();
//							if (!isset($author) || trim($author)==='')
//								$author = 'An'
//							$var > 2 ? true : false) get_the_author()
//							?><!--</span>-->
<!---->
<!--						--><?php //endif; ?>
<!---->
<!--						--><?php //if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
<!--							<span class="comments-link"> --><?php //comments_popup_link( __( 'Leave a Comment', 'athemes' ), __( '1 Comment', 'athemes' ), __( '% Comments', 'athemes' ) ); ?><!--</span>-->
<!--						--><?php //endif; ?>
						<!-- .entry-meta -->
					</div>

					</header>




					<div class="clearfix entry-content container-fluid">
						<div class="row-fluid">
							<div class="span5">
								<?php the_content(); ?>
							</div>
							<div class="span1">
								=>
							</div>
							<div class="span6">

								<?php echo nl2br(wptexturize(get_post_meta( $queryObject->post->ID, 'zombie_text', 1 ))); ?>
							</div>
						</div>
					</div>

				<?php
				}
			}
		?>



		<!-- #content --></div>
	<!-- #primary --></div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>