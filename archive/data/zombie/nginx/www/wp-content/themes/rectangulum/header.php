<?php
/**
 * @package Rectangulum
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

<?php
	if(  true === get_theme_mod( 'rectangulum_display_topbar' ) ) {
?>
<style type="text/css">
.navigation-main {margin: 24px 72px 0 0;}
.menu-toggle {right: 24px;}

@media (max-width: 768px) {
.menu-toggle {right: 12px;}
}
</style>

<?php
	}
?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<?php do_action( 'before' ); ?>

<header id="masthead" class="site-header clearfix" role="banner">

		<div class="site-branding">

<?php $logo = get_theme_mod( 'logo_upload' );
	if ( !empty($logo) ) : ?>

<?php if ( !is_front_page() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
	<img src="<?php echo get_theme_mod( 'logo_upload' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo alignleft" />
	</a>
<?php else : ?>
	<img src="<?php echo get_theme_mod( 'logo_upload' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo alignleft" />
<?php endif; //!is_front_page() ?>

	<?php endif; //!empty ?>

<div id="header-title">
	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
	
</div><!--header-title-->

		</div><!--.site-branding-->

		<div class="site-menu">
	<nav id="site-navigation" class="navigation-main" role="navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 4 ) ); ?>
<?php
if ( false === get_theme_mod( 'rectangulum_display_topbar' ) ) : ?>
		<a href="#" class="toggle-top"></a>
<?php endif;?>
	</nav><!-- #site-navigation -->
		</div><!--site-menu-->

</header><!-- #masthead -->

<?php if ( false === get_theme_mod( 'rectangulum_display_topbar' ) ) : ?>
<div class="top-wrapper clearfix">
	<div class="top-left">
		<aside class="widget_search">
		<?php get_search_form(); ?>
		</aside>
	</div>
	<div class="top-right">
	<?php if ( has_nav_menu( 'top' ) ) {
wp_nav_menu( array( 'theme_location' => 'top', 'depth' => 1 ) );
} ?>

<?php if ( has_nav_menu( 'social' ) ) {
wp_nav_menu(
	array(
	'theme_location'  => 'social',
	'menu_id'         => 'menu-social',
	'depth'           => 1,
	'link_before'     => '<span class="screen-reader-text">',
	'link_after'      => '</span>',
	'fallback_cb'     => '',
	)
);
} ?>
	</div>
</div><!--.top-wrapper-->
<?php endif;?>

	<div id="main" class="site-main clearfix">