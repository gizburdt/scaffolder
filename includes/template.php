<?php

// Block direct access
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add favicon
 */
function scaffold_favicon()
{
	echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/assets/images/favicon.ico" type="image/x-icon">';
}
add_action( 'wp_head', 'scaffold_favicon' );