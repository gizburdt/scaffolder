<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- .site -->
<div class="site">

    <header class="site-header">
        <nav class="navbar site-navigation">
            <div class="navbar-header">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand logo"><?php bloginfo('name'); ?></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#site-navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <?php wp_nav_menu(array(
                'theme_location'    => 'primary-menu',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'site-navigation',
                'items_wrap'        => '<ul id="%1$s" class="%2$s nav navbar-nav">%3$s</ul>',
                'depth'             => 0
            )); ?>
        </nav>
    </header>

    <!-- .site-content -->
    <div class="site-content">

        <?php
            /**
             * scaffolder_site_content_start hook.
             */
            do_action('scaffolder_site_content_open');
        ?>

        <!-- .layout -->
        <div class="layout">