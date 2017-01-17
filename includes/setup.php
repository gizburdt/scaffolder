<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('scaffolder_setup')) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function scaffolder_setup()
{
    // Textdomain
    load_theme_textdomain('scaffolder', get_template_directory().'/languages');
    load_child_theme_textdomain('scaffolder', get_stylesheet_directory().'/languages');

    // Theme support
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));

    // Editor
    add_editor_style('assets/css/editor-style.css');

    // Menus
    register_nav_menus(array(
        'primary-menu'   => __('Primary menu', 'scaffolder'),
        'secondary-menu' => __('Secondary menu', 'scaffolder'),
        'footer-menu'    => __('Footer menu', 'scaffolder')
    ));
}
endif;
add_action('after_setup_theme', 'scaffolder_setup');

/**
 * Init for Scaffolder Child.
 */
function scaffolder_child_init()
{
    do_action('scaffolder_child_init');
}
add_action('after_setup_theme', 'scaffolder_child_init');
