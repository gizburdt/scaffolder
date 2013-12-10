<?php

// Block direct access
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Independent filters
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Body classes
 */
function scaffold_body_class( $classes ) 
{
    global $is_gecko, $is_IE, $is_opera, $is_safari, $is_chrome;  

    if( $is_gecko )      	$classes[] = 'gecko';  
    elseif( $is_opera )  	$classes[] = 'opera';  
    elseif( $is_safari )	$classes[] = 'safari';  
    elseif( $is_chrome )	$classes[] = 'chrome';  
    elseif( $is_IE )		$classes[] = 'ie';  
    else               		$classes[] = 'unknown-browser';

    if( is_singular() )
    {
    	global $post;
        foreach( ( get_the_category( $post->ID ) ) as $category ) 
            $classes[] = 'term-' . $category->category_nicename;

        $classes[] = 'singular';
    }

    if( is_multi_author() ) 
		$classes[] = 'group-blog';

	if( is_archive() || is_search() || is_home() )
		$classes[] = 'list-view';

    return $classes;  
}
add_filter( 'body_class', 'scaffold_body_class' );

/**
 * Remove generator
 */
function scaffold_remove_wp_version() 
{
	return '';
}
add_filter( 'the_generator', 'scaffold_remove_wp_version' );

/**
 * WP title
 */
function scaffold_wp_title( $title, $sep ) 
{
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentyfourteen' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'scaffold_wp_title', 10, 2 );

/**
 * Nav object classes
 */
function scaffold_add_extra_menu_classes( $objects ) 
{
    $objects[1]->classes[] = 'first';
    $objects[count( $objects )]->classes[] = 'last';

    return $objects;
}
add_filter( 'wp_nav_menu_objects', 	'scaffold_add_extra_menu_classes' );

/**
 * Mail from (mail)
 */
function scaffold_new_mail_from( $email ) 
{
    $email = get_bloginfo( 'admin_email' );
 
    return $email;
}	
add_filter( 'wp_mail_from', 'scaffold_new_mail_from' );

/**
 * Mail from (name)
 */
function scaffold_new_mail_from_name( $name ) 
{
    $name = get_bloginfo( 'name' );
 
    return $name;
}
add_filter( 'wp_mail_from_name', 'scaffold_new_mail_from_name' );











