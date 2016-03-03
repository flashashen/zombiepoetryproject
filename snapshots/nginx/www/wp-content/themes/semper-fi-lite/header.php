<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->

    <!-- Begin WordPress Header -->
    <?php wp_head(); ?>
    <!-- End WordPress Header -->
</head>

<body <?php body_class(); ?>>

<ul class="header">
<?php if (get_theme_mod('header_image_setting') != '') { echo '<a href="' . home_url() . '"><li class="website_logo"><img class="logo2" src="' . get_theme_mod('header_image_setting') . '" /></li></a>' . "\n\n";} else {?>
	<h1 id="fittext"><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a><i><?php bloginfo('description');?></i></h1><?php } ?>
    
	<?php if ( has_nav_menu( 'bar' ) ) :  wp_nav_menu( array( 'theme_location' => 'bar', 'depth' => 2 ) ); else : ?>
	<?php wp_list_pages( 'title_li=&depth=2' ); ?>
	<?php endif; ?>
	<?php if ( get_theme_mod('facebook_setting') != 'The url link goes in here.' ) : ?><li><a href="<?php echo get_theme_mod('facebook_setting') ;?>" class="fontello" target="_blank">F</a></li><?php endif; ?>
    <?php if ( ( get_theme_mod('twitter_setting') != 'The url link goes in here.' ) && ( get_theme_mod('twitter_setting') != '' ) ) : ?><li><a href="<?php echo get_theme_mod('twitter_setting') ;?>" class="fontello" target="_blank">T</a></li><?php endif; ?>
    <?php if ( ( get_theme_mod('instagram_setting') != 'The url link goes in here.' ) && ( get_theme_mod('instagram_setting') != '' ) ) : ?><li><a href="<?php echo get_theme_mod('instagram_setting') ;?>" class="fontello" target="_blank">I</a></li><?php endif; ?>
    <?php if ( ( get_theme_mod('google_plus_setting') != 'The url link goes in here.' ) && ( get_theme_mod('google_plus_setting') != '' ) ) : ?><li><a href="<?php echo get_theme_mod('google_plus_setting') ;?>" class="fontello" target="_blank">g</a></li><?php endif; ?>
    <?php if ( ( get_theme_mod('youtube_setting') != 'The url link goes in here.' ) && ( get_theme_mod('youtube_setting') != '' ) ) : ?><li><a href="<?php echo get_theme_mod('youtube_setting') ;?>" class="fontello" target="_blank">Y</a></li><?php endif; ?>
    <?php if ( ( get_theme_mod('vimeo_setting') != 'The url link goes in here.' ) && ( get_theme_mod('vimeo_setting') != '' ) ) : ?><li><a href="<?php echo get_theme_mod('vimeo_setting') ;?>" class="fontello" target="_blank">V</a></li><?php endif; ?>
    <?php if ( ( get_theme_mod('soundcloud_setting') != 'The url link goes in here.' ) && ( get_theme_mod('soundcloud_setting') != '' ) ) : ?><li><a href="<?php echo get_theme_mod('soundcloud_setting') ;?>" class="fontello target="_blank">S</a></li><?php endif; ?>
    <?php if ( get_theme_mod('navi_search_setting') == 'on' ) : ?><li><form role="search" method="get" id="navi_search" action="<?php echo home_url(); ?>/" ><input type="text" value="Search" onFocus="if(this.value == 'Search') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Search'; }"  name="s" id="s" /></form></li><?php endif; ?>
</ul>

<main>
    
    <div class="spacing"></div>
    
    <div class="content">
