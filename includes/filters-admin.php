<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

// Only in admin
if (! is_admin()) {
    return;
}

/**
 * Remove contactmethods.
 */
function scaffolder_edit_contactmethods($methods)
{
    unset($methods['aim']);
    unset($methods['jabber']);
    unset($methods['yim']);

    return $methods;
}
add_filter('user_contactmethods', 'scaffolder_edit_contactmethods');

/**
 * Add MCE.
 */
function scaffolder_enable_more_buttons($buttons)
{
    if (! in_array('hr', $buttons)) {
        $buttons[] = 'hr';
    }

    return $buttons;
}
add_filter('mce_buttons', 'scaffolder_enable_more_buttons');

/**
 * Remove menu items.
 */
function scaffolder_remove_menu_pages()
{
    remove_menu_page('link-manager.php');
}
add_action('admin_menu', 'scaffolder_remove_menu_pages');
