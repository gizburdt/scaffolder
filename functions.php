<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

// Set content_width
if (! isset($content_width)) {
    $content_width = 640;
}

// Build url
if (! defined('SCAFFOLDER_BUILD_URL')) {
    define('SCAFFOLDER_BUILD_URL', get_stylesheet_directory_uri().'/assets');
}

/**
 * Setup.
 */
require get_template_directory().'/includes/setup.php';

/**
 * Scaffolder.
 */
require get_template_directory().'/includes/scaffolder.php';

/**
 * Assets.
 */
require get_template_directory().'/includes/assets.php';

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
