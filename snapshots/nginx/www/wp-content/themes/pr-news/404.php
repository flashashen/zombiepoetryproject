<?php get_header(); ?>
<div class="container"> 
	<div id="content">
		<div class="row">
		<?php prpin_get_sidebar_single('left'); ?>
			<div class="<?php echo prpin_get_contentspan(); ?>">			
						<div id="post-404"  class="post-wrapper">
							<div class="h1-wrapper">
							<h1><?php _e( '404 Error: Page Not Found', 'prpin' ); ?></h1>
						</div>	
        						<div class="post-content"> 
  <h3>		<?php _e('Apologies, but the page you requested could not be found.', 'prpin') ?></h3> 
						<?php _e('Perhaps searching will help:', 'prpin'); ?> 
						<?php get_search_form(); ?> 		
						</div>						
					</div>			
				</div>
		<?php prpin_get_sidebar_single('right'); ?>
	</div>
</div>	
</div>
  <div id="scroll-top"><a href="#"><i class="fa fa-chevron-up fa-3x"></i></a></div>
</div>
<?php get_footer(); ?>