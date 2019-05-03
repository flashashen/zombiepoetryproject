<?php // Zombie Posts - HTML5 Submission Form

if (!function_exists('add_action')) die();

global $usp_options, $current_user; 
get_currentuserinfo();
if ($usp_options['disable_required']) {
	$required = ''; 
	$captcha = '';
	$files = '';
} else {
	$required = ' data-required="true" required';
	$captcha = ' user-submitted-captcha'; 
	$files = ' usp-required-file';
} ?>



	<form id="usp_form" method="post" enctype="multipart/form-data" action="">
		<div id="usp-error-message" class="usp-callout-failure usp-hidden"></div>
		<div id="usp-success-message" class="usp-callout-success usp-hidden"></div>


		<?php echo usp_error_message();

		if (isset($_GET['success']) && $_GET['success'] == '1') :
			echo '<div id="usp-success-message">'. $usp_options['success-message'] .'</div>';
		else :

		{ ?>

			<!-- react/redux infect app. Lives inside of existing form for now -->
			<div id="root">
				<link rel="stylesheet" id="zombie2_style-css" href="/wp-content/plugins/zombie-posts/resources/infect/css/infectbundle.css" type="text/css" media="all">
			<script type="text/javascript" src="/wp-content/plugins/zombie-posts/resources/infect/js/infectbundle.js?ver=4.3.1"></script>
			<script type="text/javascript" src="/wp-content/plugins/zombie-posts/resources/infect/js/infectbundle.js.map"></script>



			<div id="captcha_zombie">

				<?php if( function_exists( 'cptch_display_captcha_custom' ) ) {
					echo "<input type='hidden' name='cntctfrm_contact_action' value='true' />"; echo cptch_display_captcha_custom();
				} ?>

				<div id="usp-submit">

					<?php if (!empty($usp_options['redirect-url'])) { ?>

						<input class="usp-hidden exclude" type="hidden" name="redirect-override" value="<?php echo $usp_options['redirect-url']; ?>">
					<?php } ?>
					<?php if ($usp_options['usp_use_author'] == true) { ?>

						<input class="usp-hidden exclude" type="hidden" name="user-submitted-name" value="<?php echo $current_user->user_login; ?>">
					<?php } ?>
					<?php if ($usp_options['usp_use_url'] == true) { ?>

						<input class="usp-hidden exclude" type="hidden" name="user-submitted-url" value="<?php echo $current_user->user_url; ?>">
					<?php } ?>
					<?php if ($usp_options['usp_use_cat'] == true) { ?>

						<input class="usp-hidden exclude" type="hidden" name="user-submitted-category" value="<?php echo $usp_options['usp_use_cat_id']; ?>">
					<?php } ?>

					<input class="exclude" name="user-submitted-post" id="user-submitted-post" type="submit" value="<?php _e('Submit Post', 'usp'); ?>">
					<?php wp_nonce_field('usp-nonce', 'usp-nonce', false); ?>

					<!-- for unspecified zombie artifacts -->
<!--					<input type="hidden" name="zombie-artifacts" id="zombie-artifacts" />-->
<!--					<input type="hidden" name="zombie-text-full" id="zombie-text-full" />-->

					<!-- for zombie text ajax fetch -->
					<input type="hidden" name="action" value="zombieform_action" />

				</div>

				<hr/>

			</div>


		<?php } endif; ?>


	</form>
</div>




<script>(function(){var e = document.getElementById('coldform_verify'); if(e) e.parentNode.removeChild(e);})();</script>
<!-- Zombie Posts @ https://perishablepress.com/zombie-posts/ -->
