<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package so-simple-75
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta name="generator" content="<?php echo esc_attr( sprintf( __( 'So Simple (%s) - Designed and built by Press75', 'so-simple-75' ), THEME_VERSION ) ); ?>">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php if( get_sosimpleoption('favicon') ) : ?>
			<link rel="icon" href="<?php echo esc_url( get_sosimpleoption('favicon') ); ?>" type="image/x-icon">
		<?php else: ?>
			<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/x-icon">
		<?php endif; ?>

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">

		<?php wp_head(); ?>

		<?php include('assets/images/icons.svg'); ?>

		<!--[if lt IE 9]>
		    <script src="<?php echo get_template_directory_uri() . '/assets/js/html5shiv.min.js';?>"></script>
		    <script src="<?php echo get_template_directory_uri() . '/assets/js/respond.min.js';?>"></script>
		<![endif]-->

		<!--[if IE 9]> <html class="ie9" lang="en"> <![endif]-->
	</head>

	<body <?php body_class(); ?>>
		
		<div id="page" class="hfeed site">
			
			<header class="site-header">
				
			    <div class="menu-icon">
			        <div class="menu-global menu-top"></div>
			        <div class="menu-global menu-middle"></div>
			        <div class="menu-global menu-bottom"></div>
				</div>
				
				<nav class="col-xs-12 col-sm-6 main-navigation no-padding" role="navigation">
					<?php 
						wp_nav_menu( 
							array( 
								'theme_location' => 'main_menu',
								'depth' => 2
							)
						); 
					?>
				</nav><!-- #site-navigation -->

				<div class="site-logo">
					<?php $logo = get_sosimpleoption('logo'); ?>
					<?php if ( $logo ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" rel="home"><img src="<?php echo esc_url( $logo ); ?>" class="logo"></a>
						<p class="site-description"><?php echo ( get_bloginfo( 'description' ) ? esc_textarea(get_bloginfo( 'description' ) ) : null ); ?></p>
					<?php else: ?>	
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<p class="site-description"><?php echo ( get_bloginfo( 'description' ) ? esc_textarea(get_bloginfo( 'description' ) ) : null ); ?></p>
					<?php endif; ?>
				</div>
			</header>
			
			<div id="content" class="site-content">
