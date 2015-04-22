<?php

// Block direct access
if( ! defined( 'ABSPATH' ) ) exit;

// Only in admin
if( ! is_admin() ) return;

/**
 * Remove contactmethods
 */
function scaffold_edit_contactmethods( $methods )
{
	unset( $methods['aim'] );
	unset( $methods['jabber'] );
	unset( $methods['yim'] );
	
	return $methods;
}
add_filter( 'user_contactmethods', 'scaffold_edit_contactmethods' );

/**
 * Add MCE
 */
function scaffold_enable_more_buttons( $buttons ) 
{
    if( ! in_array('hr', $buttons)) {
        $buttons[] = 'hr';
    }

	return $buttons;
}
add_filter( 'mce_buttons', 'scaffold_enable_more_buttons' );

/**
 * Remove menu items
 */
function scaffold_remove_menu_pages() 
{
	remove_menu_page( 'link-manager.php' );
}
add_action( 'admin_menu', 'scaffold_remove_menu_pages' );