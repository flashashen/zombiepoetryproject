<?php if ( shopp( 'product.found' ) ) : ?>

	<?php /*shopp( 'product.gallery', 'p_setting=main-image&thumbsetting=gallery-thumbnails' ); */

    shopp( 'product.coverimage', 'setting=main-image&itemprop=image' );

	shopp('product.schema'); ?>

    <div class="price_and_options">

        <h3 class="price">
            <?php shopp( 'product.price' ); ?><?php if ( shopp( 'product.freeshipping' ) ) _e( ' - Free Shipping!', 'Shopp' ); ?>
        </h3>
    
        <form action="<?php shopp( 'cart.url' ); ?>" method="post" class="shopp product validate validation-alerts">
    
            <div class="add_to_cart">
                <?php shopp( 'product.quantity', 'class=selectall&input=menu' ); ?>
                <?php shopp( 'product.addtocart' ); ?>
            </div>
    
            <?php if ( shopp( 'product.has-variations' ) ) : ?>
            
                <?php shopp( 'product.variations', 'mode=multiple&label=true&defaults=' . __( 'Select an option', 'Shopp') . '&before_menu=<div class="variations_shopp">&after_menu=</div>' ); ?>
    
            <?php endif; ?>
    
            <?php if ( shopp( 'product.has-addons' ) ) : ?>
            
                <?php shopp( 'product.addons', 'mode=menu&label=true&defaults=' . __( 'Select an add-on', 'Shopp') . '&before_menu=<div class="addons_shopp">&after_menu=</div>' ); ?>
            
            <?php endif; ?>
    
        </form>
        
    </div>

	<?php shopp( 'product.description' ); ?>

	<?php /* if ( shopp( 'product.has-specs' ) ) : ?>
		<dl class="details">
			<?php while ( shopp( 'product.specs' ) ) : ?>
				<dt><?php shopp( 'product.spec', 'name' ); ?>:</dt>
				<dd><?php shopp( 'product.spec', 'content' ); ?></dd>
			<?php endwhile; ?>
		</dl>
	<?php endif; */ ?>

<?php else : ?>
	<h3><?php _e( 'Product Not Found', 'Shopp' ); ?></h3>
	<p><?php _e( 'Sorry! The product you requested is not found in our catalog!', 'Shopp' ); ?></p>
<?php endif; ?>