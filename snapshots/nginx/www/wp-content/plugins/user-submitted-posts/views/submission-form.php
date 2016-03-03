<?php // User Submitted Posts - HTML5 Submission Form

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

<!-- User Submitted Posts @ https://perishablepress.com/user-submitted-posts/ -->
<div id="user-submitted-posts">
	<?php if ($usp_options['usp_form_content'] !== '') echo $usp_options['usp_form_content']; ?>
	
	<form id="usp_form" method="post" enctype="multipart/form-data" action="">
		<div id="usp-error-message" class="usp-callout-failure usp-hidden"></div>
		<div id="usp-success-message" class="usp-callout-success usp-hidden"></div>
		<?php echo usp_error_message();
		
		if (isset($_GET['success']) && $_GET['success'] == '1') :
			echo '<div id="usp-success-message">'. $usp_options['success-message'] .'</div>';
		else :
		
		if (($usp_options['usp_name'] == 'show' || $usp_options['usp_name'] == 'optn') && ($usp_options['usp_use_author'] == false)) { ?>
		
		<fieldset class="usp-name">
			<label for="user-submitted-name"><?php _e('Your Name', 'usp'); ?></label>
			<input name="user-submitted-name" type="text" value="" placeholder="<?php _e('Your Name', 'usp'); ?>"<?php if (usp_check_required('usp_name')) echo $required; ?> class="usp-input">
		</fieldset>
		<?php } if (($usp_options['usp_url'] == 'show' || $usp_options['usp_url'] == 'optn') && ($usp_options['usp_use_url'] == false)) { ?>
		
		<fieldset class="usp-url">
			<label for="user-submitted-url"><?php _e('Your URL', 'usp'); ?></label>
			<input name="user-submitted-url" type="text" value="" placeholder="<?php _e('Your URL', 'usp'); ?>"<?php if (usp_check_required('usp_url')) echo $required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_email'] == 'show' || $usp_options['usp_email'] == 'optn') { ?>
		
		<fieldset class="usp-email">
			<label for="user-submitted-email"><?php _e('Your Email', 'usp'); ?></label>
			<input name="user-submitted-email" type="text" value="" placeholder="<?php _e('Your Email', 'usp'); ?>"<?php if (usp_check_required('usp_email')) echo $required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_title'] == 'show' || $usp_options['usp_title'] == 'optn') { ?>
		
		<fieldset class="usp-title">
			<label for="user-submitted-title"><?php _e('Post Title', 'usp'); ?></label>
			<input name="user-submitted-title" type="text" value="" placeholder="<?php _e('Post Title', 'usp'); ?>"<?php if (usp_check_required('usp_title')) echo $required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_tags'] == 'show' || $usp_options['usp_tags'] == 'optn') { ?>
		
		<fieldset class="usp-tags">
			<label for="user-submitted-tags"><?php _e('Post Tags', 'usp'); ?></label>
			<input name="user-submitted-tags" type="text" value="" placeholder="<?php _e('Post Tags', 'usp'); ?>"<?php if (usp_check_required('usp_tags')) echo $required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_captcha'] == 'show') { ?>
		
		<fieldset class="usp-captcha">
			<label for="user-submitted-captcha"><?php echo $usp_options['usp_question']; ?></label>
			<input name="user-submitted-captcha" type="text" value="" placeholder="<?php _e('Antispam Question', 'usp'); ?>"<?php echo $required; ?> class="usp-input exclude<?php echo $captcha; ?>">
		</fieldset>
		<?php } if (($usp_options['usp_category'] == 'show' || $usp_options['usp_category'] == 'optn') && ($usp_options['usp_use_cat'] == false)) { ?>
		
		<fieldset class="usp-category">
			<label for="user-submitted-category"><?php _e('Post Category', 'usp'); ?></label>
			<select name="user-submitted-category"<?php if (usp_check_required('usp_category')) echo $required; ?> class="usp-select">
				<option value=""><?php _e('Please select a category..', 'usp'); ?></option>
				<?php foreach($usp_options['categories'] as $categoryId) { $category = get_category($categoryId); if (!$category) { continue; } ?>
				
				<option value="<?php echo $categoryId; ?>"><?php $category = get_category($categoryId); echo sanitize_text_field($category->name); ?></option>
				<?php } ?>
				
			</select>
		</fieldset>
		<?php } if ($usp_options['usp_content'] == 'show' || $usp_options['usp_content'] == 'optn') { ?>
		
		<fieldset class="usp-content">
			<?php if ($usp_options['usp_richtext_editor'] == true) { ?>
			
			<div class="usp_text-editor">
			<?php $settings = array(
				    'wpautop'          => true,  // enable rich text editor
				    'media_buttons'    => true,  // enable add media button
				    'textarea_name'    => 'user-submitted-content', // name
				    'textarea_rows'    => '10',  // number of textarea rows
				    'tabindex'         => '',    // tabindex
				    'editor_css'       => '',    // extra CSS
				    'editor_class'     => 'usp-rich-textarea', // class
				    'teeny'            => false, // output minimal editor config
				    'dfw'              => false, // replace fullscreen with DFW
				    'tinymce'          => true,  // enable TinyMCE
				    'quicktags'        => true,  // enable quicktags
				    'drag_drop_upload' => true, // enable drag-drop
				);
				wp_editor('', 'uspcontent', apply_filters('usp_editor_settings', $settings)); ?>
				
			</div>
			<?php } else { ?>
				
			<label for="user-submitted-content"><?php _e('Post Content', 'usp'); ?></label>
			<textarea name="user-submitted-content" rows="5" placeholder="<?php _e('Post Content', 'usp'); ?>"<?php if (usp_check_required('usp_content')) echo $required; ?> class="usp-textarea"></textarea>
			<?php } ?>
			
		</fieldset>
		<?php } if ($usp_options['usp_images'] == 'show') { ?>
		<?php if ($usp_options['max-images'] !== 0) { ?>
		
		<fieldset class="usp-images">
			<label for="user-submitted-image"><?php _e('Upload an Image', 'usp'); ?></label>
			<div id="usp-upload-message"><?php echo $usp_options['upload-message']; ?></div>
			<div id="user-submitted-image">
			<?php // upload files
			$minImages = intval($usp_options['min-images']);
			$maxImages = intval($usp_options['max-images']);
			$addAnother = $usp_options['usp_add_another'];
			
			if ($addAnother == '') $addAnother = '<a href="#" id="usp_add-another" class="usp-no-js">' . __('Add another image', 'usp') . '</a>';
			if ($minImages > 0) : ?>
				<?php for ($i = 0; $i < $minImages; $i++) : ?>
						
				<input name="user-submitted-image[]" type="file" size="25"<?php echo $required; ?> class="usp-input usp-clone<?php echo $files; ?> exclude">
				<?php endfor; ?>
				<?php if ($minImages < $maxImages) : echo $addAnother; endif; ?>
			<?php else : ?>
					
				<input name="user-submitted-image[]" type="file" size="25" class="usp-input usp-clone exclude">
				<?php echo $addAnother; ?>
			<?php endif; ?>
				
			</div>
			<input class="usp-hidden exclude" type="hidden" name="usp-min-images" id="usp-min-images" value="<?php echo $usp_options['min-images']; ?>">
			<input class="usp-hidden exclude" type="hidden" name="usp-max-images" id="usp-max-images" value="<?php echo $usp_options['max-images']; ?>">
		</fieldset>
		<?php } ?>
		<?php } ?>
		
		<fieldset id="coldform_verify" style="display:none;">
			<label for="user-submitted-verify"><?php _e('Human verification: leave this field empty.', 'usp'); ?></label>
			<input class="exclude" name="user-submitted-verify" type="text" value="">
		</fieldset>
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
		</div>
		<?php endif; ?>

	</form>
</div>
<script>(function(){var e = document.getElementById('coldform_verify'); if(e) e.parentNode.removeChild(e);})();</script>
<!-- User Submitted Posts @ https://perishablepress.com/user-submitted-posts/ -->
