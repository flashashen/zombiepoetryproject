
<?php if ( shopp( 'product.found' ) ) : ?>
	<div class="sideproduct">
		<a href="<?php shopp( 'product.url' ); ?>"><?php shopp( 'product.coverimage', 'setting=thumbnails' ); ?></a>
		
		<h3><a href="<?php shopp( 'product.url' ); ?>"><?php shopp( 'product.name' ); ?></a></h3>
		
		<?php if ( shopp( 'product.onsale' ) ) : ?>
			<p class="original price"><?php shopp( 'product.price' ); ?></p>
			<p class="sale price"><?php shopp( 'product.saleprice' ); ?></p>
		<?php else : ?>
			<p class="price"><?php shopp( 'product.price' ); ?></p>
		<?php endif; ?>
	</div>
<?php endif; ?>