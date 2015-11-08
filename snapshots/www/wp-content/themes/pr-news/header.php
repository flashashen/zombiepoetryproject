<!DOCTYPE html>
<!--[if IE 6]><html id="ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html id="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
    <head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php if(of_get_option('prpin_favicon')) { ?><link rel="shortcut icon" href="<?php echo of_get_option('prpin_favicon'); ?>" />
	<?php } ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); 	?>
</head>
<body <?php body_class(); ?>>
<div id="navbar"> 
<nav  class="navbar  navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
        <div class="navbar-header">
    		     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			     <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
 
       <a class="navbar-brand" href="<?php echo home_url(); ?>">
            <i class="fa fa-home"></i> 
            </a>  
        </div>
<?php  wp_nav_menu( array(
                'theme_location'    => 'top_nav',
                'depth'             => 12,
       			'menu_class'        => 'nav navbar-nav collapse navbar-collapse',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
        ?>
 		  <div class="pull-right">
<?php    if ('' != $prsearch = of_get_option('prpin_search')) { ?>						
	<div class="pull-right">
 <form class="navbar-form" role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="<?php _e('Search', 'prpin'); ?>" name="s" id="s" value="<?php the_search_query(); ?>">   </div>     
    </form>
  </div> 
<?php } 
if ('' != $prrss = of_get_option('prpin_rss')) { ?>			
					<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Subscribe to our RSS Feed', 'prpin'); ?>" class="social pull-right"><i class="fa fa-rss fa-lg"></i></a>					
	<?php } 
if ('' != $google = of_get_option('prpin_google')) { ?>
					<a href="<?php echo $google; ?>" title="<?php _e('Find us on Google+', 'prpin'); ?>" class="social pull-right"><i class="fa fa-google-plus fa-lg"></i></a>
	<?php } 

if ('' != $linkedin = of_get_option('prpin_linkedin')) { ?>
					<a href="<?php echo $linkedin; ?>" title="<?php _e('Find us on Linkedin', 'prpin'); ?>" class="social pull-right"><i class="fa fa-linkedin fa-lg"></i></a>	
						<?php } 
if ('' != $pinterest = of_get_option('prpin_pinterest')) { ?>
					<a href="<?php echo $pinterest; ?>" title="<?php _e('Find us on Pinterest', 'prpin'); ?>" class="social pull-right"><i class="fa fa-pinterest fa-lg"></i></a>	
						<?php } 						
if ('' != $twitter = of_get_option('prpin_twitter')) { ?>
					<a href="<?php echo $twitter; ?>" title="<?php _e('Follow us on Twitter', 'prpin'); ?>" class="social pull-right"><i class="fa fa-twitter fa-lg"></i></a>
					<?php } 
if ('' != $facebook = of_get_option('prpin_facebook')) { ?>
					<a href="<?php echo $facebook; ?>" title="<?php _e('Find us on Facebook', 'prpin'); ?>" class="social pull-right"><i class="fa fa-facebook fa-lg"></i></a>
					<?php } ?>
		</div> <!-- collapse -->
      </div> <!-- container -->
</nav>
</div> <!-- #navbar -->
<div class="site-header"></div> 
 
<!-- //header.php --> 

 