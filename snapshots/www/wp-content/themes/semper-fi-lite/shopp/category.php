
<?php shopp('collection.description') ?>

<?php if ( shopp( 'collection.hasproducts', 'load=coverimages' ) ) : ?>

<?php while( shopp( 'collection.products' ) ) : ?>

<div class="shop_item <?php if ( shopp('collection.row') ) echo ' first'; ?>" itemscope itemtype="http://schema.org/Product">

    <h6 class="post_title">
        <time itemscope itemtype="http://schema.org/Offer"><span itemprop="price"><?php shopp( 'product.saleprice', 'starting=' . __( 'from', 'Shopp' ) ); ?></span></time>
        <a href="<?php shopp( 'product.url' ); ?>"><span itemprop="name"><?php shopp( 'product.name' ); ?></span></a>
    </h6>
            
    <a href="<?php shopp( 'product.url' ); ?>" itemprop="url">
        <?php shopp( 'product.coverimage', 'setting=thumbnails&itemprop=image' ); ?>
    </a>

    <a href="<?php shopp( 'product.url' ); ?>">
        <p><span itemprop="description"><?php shopp( 'product.summary' ); ?></span></p>
    </a>

</div>

<?php endwhile; ?>

<div class="alignright">
    <?php shopp( 'collection.pagination', 'show=10' ); ?>
</div>

<?php else : ?>
	<?php if ( ! shopp('storefront.is-landing') ) shopp( 'storefront.breadcrumb' ); ?>
	<p class="notice"><?php _e( 'No products were found.', 'Shopp' ); ?></p>
<?php endif; ?>