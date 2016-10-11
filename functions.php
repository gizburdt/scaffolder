<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

// Set content_width
if (! isset($content_width)) {
    $content_width = 640;
}

// Assets/vendor url
if (! defined('SCAFFOLDER_BOWER_URL')) {
    define('SCAFFOLDER_BOWER_URL', get_stylesheet_directory_uri().'/resources/assets/vendor');
}

// Build url
if (! defined('SCAFFOLDER_BUILD_URL')) {
    define('SCAFFOLDER_BUILD_URL', get_stylesheet_directory_uri().'/assets');
}

// Scaffolder setup
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
    add_theme_support('post-formats', array(/* 'aside', 'link', 'gallery', 'status', 'quote', 'image' */));
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));

    // Editor
    add_editor_style('assets/css/editor-style.css');

    // Menus
    register_nav_menus(array(
        'primary-menu'      => __('Primary menu', 'scaffolder'),
        'secondary-menu'    => __('Secondary menu', 'scaffolder'),
        'footer-menu'       => __('Footer menu', 'scaffolder')
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

/**
 * Enqueue scripts and styles.
 */
function scaffolder_styles_scripts()
{
    // Styles
    add_action('wp_enqueue_scripts', 'scaffolder_register_styles');
    add_action('wp_enqueue_scripts', 'scaffolder_enqueue_styles');

    // Scripts
    add_action('wp_enqueue_scripts', 'scaffolder_register_scripts');
    add_action('wp_enqueue_scripts', 'scaffolder_enqueue_scripts');
}
add_action('init', 'scaffolder_styles_scripts');

/**
 * Register styles.
 */
function scaffolder_register_styles()
{
    wp_register_style('style', SCAFFOLDER_BUILD_URL.'/css/style.css', '', '', 'screen');
}

/**
 * Enqueue styles.
 */
function scaffolder_enqueue_styles()
{
    wp_enqueue_style('style');
}

/**
 * Register scripts.
 */
function scaffolder_register_scripts()
{
}

/**
 * Enqueue scripts.
 */
function scaffolder_enqueue_scripts()
{
    if (is_singular() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

/**
 * Scaffolder.
 */
require get_template_directory().'/includes/scaffolder.php';

/**
 * All scaffolder filters.
 */
require get_template_directory().'/includes/filters.php';

/**
 * All scaffolder filters for admin.
 */
require get_template_directory().'/includes/filters-admin.php';

/**
 * Helper functions.
 */
require get_template_directory().'/includes/helpers.php';
