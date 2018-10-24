

<div id="primary" class="content-area container">


	<div id="content" class="site-content content-area" role="main">


		<?php

		$query = array (
			'posts_per_page' => 20,
//			'meta_key' => 'zombie-artifacts',
			'category_name' => 'incidents'
		);
		$queryObject = new WP_Query($query);

		if ($queryObject->have_posts()) {
			while ($queryObject->have_posts()) {
				$queryObject->the_post();

				?>
				<header class="entry-header">
					<h1 class="entry-title"><?php echo $queryObject->post->post_date; echo ". &nbsp &nbsp"; the_title() ?></h1>

					<div class="entry-meta">
						<?php echo get_post_meta( $queryObject->post->ID, 'user_submit_name', 1 ); ?>
					</div>
				</header>

				<?php the_content(); ?>
				<?php
			}
		}
		?>

	</div>


</div>