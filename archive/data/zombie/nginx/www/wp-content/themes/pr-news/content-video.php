<div class="container"> 
	<div id="content">
		<div class="row">
		<?php prpin_get_sidebar_single('left'); ?>
			<div class="<?php echo prpin_get_contentspan(); ?>">			
					<?php while (have_posts()) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('post-wrapper'); ?>>
					<?php the_title( '<div class="h1-wrapper"><h1>', '</h1></div>' ); ?>
           					<div class="post-content">
									<?php	the_content();?>
							<?php	wp_link_pages( array( 'before' => '<p><strong>' . __('Pages:', 'prpin') . '</strong>', 'after' => '</p>' ) );	?>
								<div class="clearfix"></div>
						<div class="post-meta-top">
							<div class="pull-right"><?php edit_post_link(__('Edit', 'prpin'),'<i class="fa fa-pencil"></i> ',''); ?></div>
		<div class="pull-left"><i class="fa fa-calendar"></i> <?php echo get_the_date();?> &nbsp; <i class="fa fa-user"></i> <?php the_author_posts_link(); ?></div>
	<div class="category-tag">
	<?php if(get_the_category()){ ?>
<i class="fa fa-folder-open"></i> &nbsp; <?php the_category(', '); }?>  <?php the_tags(' &nbsp; <i class="fa fa-tags"></i> &nbsp; ',', '); ?>
	 </div>
						</div>		
			
							<div id="navigation">
								<ul class="pager">
									<li class="previous"><?php previous_post_link('%link', __('<i class="fa fa-chevron-left"></i> %title', 'prpin')); ?></li>
									<li class="next"><?php next_post_link('%link', __('%title <i class="fa fa-chevron-right"></i>', 'prpin')); ?></li>
								</ul>
							</div>
						</div>
<div class="post-comments">
							<div class="post-comments-wrapper">
								<?php comments_template(); ?>
							</div>
						</div>
						
					</div>
					<?php endwhile; ?>
				</div>

		<?php prpin_get_sidebar_single('right'); ?>
	</div>
</div>	
</div>
  <div id="scroll-top"><a href="#"><i class="fa fa-chevron-up fa-3x"></i></a></div>

