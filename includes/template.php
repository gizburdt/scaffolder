<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

/*
 * Get template.
 */
function scaffolder_template($stylesheet) {
    return dirname($stylesheet);
}
add_filter('template', 'scaffolder_template');

/*
 * Set template.
 */
function scaffolder_after_switch_theme() {
    $stylesheet = get_option('template');
    if (basename($stylesheet) !== 'templates') {
        update_option('template', $stylesheet . '/templates');
    }
}
add_action('after_switch_theme', 'scaffolder_after_switch_theme');