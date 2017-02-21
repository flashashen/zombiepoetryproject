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


<div id="root">


<script>(function(){var e = document.getElementById('coldform_verify'); if(e) e.parentNode.removeChild(e);})();</script>
<!-- Zombie Posts @ https://perishablepress.com/zombie-posts/ -->
