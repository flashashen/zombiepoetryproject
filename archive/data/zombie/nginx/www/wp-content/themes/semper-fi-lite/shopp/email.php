Content-type: text/html; charset=utf-8
From: <?php shopp( 'purchase.email-from' ); ?>
To: <?php shopp( 'purchase.email-to' ); ?>
Subject: <?php shopp( 'purchase.email-subject' ); ?>

<html>
	<div id="header">
		<h1><?php bloginfo( 'name' ); ?></h1>
		<h2><?php _e( 'Order Update', 'Shopp' ); ?></h2>
	</div>
	<div id="body">
		<?php shopp( 'purchase.email-note' ); ?>
		<p class="status"><?php _e( 'Your order is', 'Shopp' ); ?>: <strong><?php shopp( 'purchase.status' ); ?></strong></p>
		<?php shopp( 'purchase.receipt' ); ?>
	</div>
</html>
