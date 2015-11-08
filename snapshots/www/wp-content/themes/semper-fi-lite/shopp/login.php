
<?php if ( shopp( 'customer.notloggedin' ) ) : ?>
	<form action="<?php shopp( 'customer.url' ); ?>" method="post" class="shopp shopp_page" id="login">
		<ul>
			<li>
				<label for="login"><?php _e( 'Account Login', 'Shopp' ); ?></label>
				<span>
					<label for="login"><?php shopp( 'customer.login-label' ); ?></label>
					<?php shopp( 'customer.account-login', 'size=20&title=' . __( 'Login', 'Shopp' ) ); ?>
				</span>
				<span>
					<label for="password"><?php _e( 'Password', 'Shopp' ); ?></label>
					<?php shopp( 'customer.password-login', 'size=20&title=' . __( 'Password', 'Shopp' ) ); ?>
				</span>
				<span><?php shopp( 'customer.login-button' ); ?></span>
			</li>
			<li>
				<a href="<?php shopp( 'customer.recover-url' ); ?>"><?php _e( 'Lost your password?', 'Shopp' ); ?></a>
			</li>
		</ul>
	</form>
<?php endif; ?>