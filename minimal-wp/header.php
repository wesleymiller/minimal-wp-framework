<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title>
		<?php
			if ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description');}       
			elseif ( is_single() || is_page() ) { single_post_title(); print ' | '; bloginfo('name'); print ' | '; bloginfo('description'); }
			elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . esc_html($s);}
			elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
			else { bloginfo('name'); wp_title('|');}
		?>
	</title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<style>article, aside, figure, footer, header, hgroup, menu, nav, section {display:block;}</style>	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php wp_enqueue_script("jquery"); ?>
	<?php wp_head(); ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'minimal-wp' ), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'minimal-wp' ), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
</head>
<body <?php body_class(); ?>>
<div class="container hfeed">
    <header>
        <div class="title">
			<a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home">
				<span><?php bloginfo( 'name' ) ?></span>
			</a>
        </div>
		<?php if ( get_header_image() != '' ) { ?>
			<div class="headerimg">
				<img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ) ?>" />
			</div>
		<?php } ?>
        <?php if ( is_home() || is_front_page() ) { ?>
            <h1 class="description"><?php bloginfo( 'description' ) ?></h1>
        <?php } else { ?>	
            <div class="description"><?php bloginfo( 'description' ) ?></div>
        <?php } ?>
    </header>
    
	<?php 
	if ( has_nav_menu( 'navigation' ) ) {
        wp_nav_menu(array(
            'menu' => 'navigation',
            'container' => 'nav',
            'container_id' => 'top-nav',
            'fallback_cb' => 'false',
            'depth' => -1
		));
     }
    ?>
    <div class="main">