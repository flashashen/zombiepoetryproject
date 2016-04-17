<?php

/*
Template Name: TestZombieTemplate
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>


				<?php
				global $wpdb;
					$options = $wpdb->get_results("SELECT * FROM wp_options order by option_id desc limit 5;");

				echo "<table>";
				foreach($options as $option){
					echo "<tr>";
					echo "<td>".$option->option_id."</td>";
					echo "<td>".$option->option_name."</td>";
					echo "<td>".$option->option_value."</td>";
					echo "<td>".$option->autoload."</td>";
					echo "</tr>";
				}
				echo "</table>";
				?>


				<script type="text/javascript">
					jQuery('#newCustomerForm').submit(zombieSubmit);

					function zombieSubmit(){

						var newCustomerForm = jQuery(this).serialize();

						jQuery.ajax({
							type:"POST",
							url: "/wp-admin/admin-ajax.php",
							data: newCustomerForm,
							success:function(data){
								jQuery("#feedback").html(data);
							}
						});

						return false;
					}
				</script>


				<form type="post" action="" id="newCustomerForm">


					<label for="option_name">Option Name:</label>
					<input name="option_name" type="text" />

					<label for="option_value">Option Value:</label>
					<input name="option_value" type="text" />

					<label for="autoload">Autoload:</label>
					<input name="autoload" type="text" />

					<input type="hidden" name="action" value="getZombie"/>
					<input type="submit">
				</form>
				<br/><br/>
				<div id="feedback"></div>
				<br/><br/>


				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

		<!-- #content --></div>
	<!-- #primary --></div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>