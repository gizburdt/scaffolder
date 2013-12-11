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
	$buttons[] = 'hr';

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
add_action( 'admin_menu', 			'scaffold_remove_menu_pages' );
		
/**
 * Remove dashboard widgets
 */
function scaffold_remove_dashboard_widgets() 
{
	global $wp_meta_boxes;

	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
	// unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] );
	// unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
}
add_action( 'wp_dashboard_setup', 	'scaffold_remove_dashboard_widgets' );
