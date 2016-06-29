<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

/*
 * Independent filters
 */
add_filter('widget_text', 'do_shortcode');

/**
 * Body classes.
 */
function scaffolder_body_class($classes)
{
    global $is_gecko, $is_IE, $is_opera, $is_safari, $is_chrome, $is_NS4, $is_lynx, $is_iphone;

    if ($is_gecko) {
        $classes[]   = 'gecko';
    } elseif ($is_opera) {
        $classes[]   = 'opera';
    } elseif ($is_safari) {
        $classes[]   = 'safari';
    } elseif ($is_lynx) {
        $classes[]   = 'lynx';
    } elseif ($is_chrome) {
        $classes[]   = 'chrome';
    } elseif ($is_NS4) {
        $classes[]   = 'ns4';
    } elseif ($is_IE) {
        $classes[]   = 'ie';
    } else {
        $classes[] = 'unknown-browser';
    }

    if ($is_iphone) {
        $classes[]   = 'iphone';
    }

    if (is_singular()) {
        global $post;
        foreach ((get_the_category($post->ID)) as $category) {
            $classes[] = 'term-'.$category->category_nicename;
        }

        $classes[] = 'singular';
    }

    if (is_multi_author()) {
        $classes[] = 'multi-author';
    }

    if (is_archive() || is_search() || is_home()) {
        $classes[] = 'list-view';
    }

    return $classes;
}
add_filter('body_class', 'scaffolder_body_class');

/**
 * Remove generator.
 */
function scaffolder_cleanup_head()
{
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
}
add_action('init', 'scaffolder_cleanup_head');

/**
 * Nav object classes.
 */
function scaffolder_add_extra_menu_classes($objects)
{
    $objects[1]->classes[]               = 'first';
    $objects[count($objects)]->classes[] = 'last';

    return $objects;
}
add_filter('wp_nav_menu_objects', 'scaffolder_add_extra_menu_classes');

/**
 * Add favicon.
 */
function scaffolder_favicon()
{
    if (file_exists(get_stylesheet_directory().'/assets/images/favicon.png')) {
        echo '<link rel="shortcut icon" type="image/png" href="'.get_stylesheet_directory_uri().'/assets/images/favicon.png">';
    }
}
add_action('wp_head', 'scaffolder_favicon');
