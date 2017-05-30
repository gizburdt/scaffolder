<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

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
    //
}

/**
 * Enqueue styles.
 */
function scaffolder_enqueue_styles()
{
    //
}

/**
 * Register scripts.
 */
function scaffolder_register_scripts()
{
    //
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
