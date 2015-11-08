<?php get_header(); ?>
	<!-- breadcrumb -->
 <?php if (is_author()) : ?>  
     <div class="container"> <div class="col-sm-12 col-md-12 col-lg-12"><div class="alert alert-info"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>        <div class="posttitle">
   <?php   $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));?>
  <i class="fa fa-user"></i> <?php _e('Posts By: ', 'prpin');  echo $curauth->display_name; ?>	                                                      
      </div></div></div>        </div>
            <?php elseif (is_search()) : ?>
<div class="container"> <div class="col-sm-12 col-md-12 col-lg-12"><div class="alert alert-info"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>     <div class="posttitle">
             <i class="fa fa-search"></i>   <?php _e('Search results: ', 'prpin');  the_search_query() ?> 
        </div></div></div>        </div>
            <?php elseif (is_category()) : ?>
        <div class="container"> <div class="col-sm-12 col-md-12 col-lg-12"><div class="alert alert-info"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>      <div class="posttitle">
                 <i class="fa fa-folder-open"></i>   <?php _e('Posts in category: ', 'prpin'); $category = get_queried_object(); echo $category->name; ?>
       </div></div></div>        </div>
            <?php elseif (is_tag()) : ?>
      <div class="container"> <div class="col-sm-12 col-md-12 col-lg-12"><div class="alert alert-info"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>     <div class="posttitle">
  <i class="fa fa-tags"></i>    <?php _e('Browsing posts tagged: ', 'prpin');  $tag = get_queried_object(); echo $tag->name; ?>
   </div></div></div>     </div>
            <?php elseif (is_archive()) : ?>
       <div class="container"> <div class="col-sm-12 col-md-12 col-lg-12"><div class="alert alert-info"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>      <div class="posttitle">
                    <?php _e('Browsing archived posts: ', 'prpin'); ?>
            </div></div></div>   </div>
            <?php endif; ?> 
<!-- // breadcrumb -->

<div class="container"> 
		<?php prpin_get_sidebar('left'); ?>
			<div class="<?php echo prpin_get_index_span(); ?>">
				<div id="masonry">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
 		<div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-4 col-md-4 col-lg-4 boxy'); ?>>
<div  class="content panel panel-default">
	<?php if(prpin_thumbnail($post->ID) ) { 
  echo prpin_thumbnail($post->ID);
} ?>	
	<div class="panel-body">
<a href="<?php the_permalink(); ?>">
		<div class="posttitle"><?php the_title(); ?></div></a>
		<?php if(prpin_thumbnail($post->ID) =='') { 
 the_excerpt(); 
} ?>
			<div class="category-tag">
<i class="fa fa-folder-open"></i> <?php the_category(', '); ?>  <?php the_tags(' &nbsp; <i class="fa fa-tags"></i> ',', '); ?>
	        </div>
	</div>
	</div>
</div><!--    //post -->

		<?php endwhile; 
		else :
 echo prpin_get_no_result(); 
 endif; ?>
			</div> <!-- //masonry -->

	<div id="navigation">
		<ul class="pager">
			<li id="navigation-next"><?php next_posts_link(__('&laquo; Previous', 'prpin')) ?></li>
			<li id="navigation-previous"><?php previous_posts_link(__('Next &raquo;', 'prpin')) ?></li>
		</ul>
	</div>

		</div>
		<?php prpin_get_sidebar('right'); ?>
	</div>
<!-- </div>
</div> -->

  <div id="scroll-top"><a href="#"><i class="fa fa-chevron-up fa-3x"></i></a></div>
 
<?php get_footer(); ?>