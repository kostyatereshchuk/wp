<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	<header id="masthead" class="site-header navbar-static-top" role="banner">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0">
                <div class="navbar-brand">
                    <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php if ( $site_logo = get_theme_mod( 'site_logo' ) ): ?>
                            <img src="<?php echo $site_logo; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
                        <?php else: ?>
                            <?php echo get_bloginfo( 'name' ); ?>
                        <?php endif; ?>
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa fa-bars"></i>
                    </span>
                </button>

                <?php

                wp_nav_menu( array(
                    'theme_location'    => 'primary',
                    'container'       => 'div',
                    'container_id'    => 'main-nav',
                    'container_class' => 'collapse navbar-collapse justify-content-end',
                    'menu_id'         => false,
                    'menu_class'      => 'navbar-nav',
                    'depth'           => 3,
                ) );

                ?>

            </nav>
        </div>
	</header>

	<div id="content" class="site-content">

