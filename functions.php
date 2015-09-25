<?php

// Block direct access
if( ! defined( 'ABSPATH' ) ) exit;

// Set content_width
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

// Assets/vendor url
if( ! defined( 'SCAFFOLD_VENDOR_URL' ) ) {
	define( 'SCAFFOLD_VENDOR_URL', WP_CONTENT_URL . '/vendor' ); // get_template_directory_uri()
}

// Assets/vendor dir
if( ! defined( 'SCAFFOLD_VENDOR_DIR' ) ) {
	define( 'SCAFFOLD_VENDOR_DIR', WP_CONTENT_DIR . '/vendor' ); // get_template_directory
}

// Cuztom dir
if( ! defined( 'CUZTOM_DIR' ) ) {
	define( 'CUZTOM_DIR', SCAFFOLD_VENDOR_DIR . '/gizburdt/cuztom/' ); // get_template_directory()
}

// Cuztom url
if( ! defined( 'CUZTOM_URL' ) ) {
	define( 'CUZTOM_URL', SCAFFOLD_VENDOR_URL . '/gizburdt/cuztom/' ); // get_stylesheet_directory_uri()
}

// Scaffold setup
if( ! function_exists( 'scaffold_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function scaffold_setup()
{
	// Textdomain
	load_theme_textdomain( 'scaffold', get_template_directory() . '/languages' );
	load_child_theme_textdomain( 'scaffold', get_stylesheet_directory() . '/languages' );

	// Theme support
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( /* 'aside', 'link', 'gallery', 'status', 'quote', 'image' */ ) );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// Editor
	add_editor_style( 'assets/css/editor-style.css' );

	// Menus
	register_nav_menus( array(
		'primary-menu'		=> __( 'Primary menu', 'scaffold' ),
		'secondary-menu'	=> __( 'Secondary menu', 'scaffold' ),
		'footer-menu'		=> __( 'Footer menu', 'scaffold' )
	) );
}
endif;
add_action( 'after_setup_theme', 'scaffold_setup' );

/**
 * Init for Scaffold Child
 */
function scaffold_child_init() {
	do_action( 'scaffold_child_init' );
}
add_action( 'after_setup_theme', 'scaffold_child_init' );

/**
 * Enqueue scripts and styles.
 */
function scaffold_styles_scripts()
{
	// Styles
	add_action( 'wp_enqueue_scripts', 	'scaffold_register_styles' );
	add_action( 'wp_enqueue_scripts', 	'scaffold_enqueue_styles' );

	// Scripts
	add_action( 'wp_enqueue_scripts', 	'scaffold_register_scripts' );
	add_action( 'wp_enqueue_scripts', 	'scaffold_enqueue_scripts' );
}
add_action( 'init', 'scaffold_styles_scripts' );

/**
 * Register styles.
 */
function scaffold_register_styles()
{
	// Vendor
	wp_register_style( 'jquery-fancybox', SCAFFOLD_VENDOR_URL . '/fancybox/source/jquery.fancybox.css', '', '', 'screen' );
	wp_register_style( 'jquery-bxslider', SCAFFOLD_VENDOR_URL . '/bxslider-4/dist/jquery.bxslider.css', '', '', 'screen' );

	// Theme
	wp_register_style( 'style', get_stylesheet_directory_uri() . '/style.css', '', '', 'screen' );
}

/**
 * Enqueue styles.
 */
function scaffold_enqueue_styles()
{
	wp_enqueue_style( 'jquery-fancybox' );
	wp_enqueue_style( 'jquery-bxslider' );
	wp_enqueue_style( 'style' );
}

/**
 * Register scripts
 */
function scaffold_register_scripts()
{
	// Vendor
	wp_register_script( 'bootstrap', SCAFFOLD_VENDOR_URL . '/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'html5shiv', SCAFFOLD_VENDOR_URL . '/html5shiv/dist/html5shiv.min.js', '', '', true );
	wp_register_script( 'modernizr', SCAFFOLD_VENDOR_URL . '/modernizr/modernizr.js', '', '', true );
	wp_register_script( 'respond', SCAFFOLD_VENDOR_URL . '/respond/dest/respond.min.js', '', '', true );
	wp_register_script( 'enquire', SCAFFOLD_VENDOR_URL . '/enquire/dist/enquire.min.js', '', '', true );
	wp_register_script( 'jquery-bxslider', SCAFFOLD_VENDOR_URL . '/bxslider-4/dist/jquery.bxslider.min.js', array( 'jquery' ), '', true);
	wp_register_script( 'jquery-fancybox', SCAFFOLD_VENDOR_URL . '/fancybox/source/jquery.fancybox.pack.js', array( 'jquery' ), '', true);
    wp_register_script( 'jquery-fitvids', SCAFFOLD_VENDOR_URL . '/fitvids/jquery.fitvids.js', array( 'jquery' ), '', true);
}

/**
 * Enqueue scripts
 */
function scaffold_enqueue_scripts()
{
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'html5shiv' );
	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'respond' );
	wp_enqueue_script( 'enquire' );
	wp_enqueue_script( 'jquery-caroufredsel' );
	wp_enqueue_script( 'jquery-bxslider' );
	wp_enqueue_script( 'jquery-fancybox' );
    wp_enqueue_script( 'jquery-fitvids' );

	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Allow automatic updates
 */
add_filter( 'automatic_updates_is_vcs_checkout', '__return_false' );

/**
 * All scaffold filters
 */
require get_template_directory() . '/includes/filters.php';

/**
 * All scaffold filters for admin
 */
require get_template_directory() . '/includes/filters-admin.php';

/**
 * Helper functions
 */
require get_template_directory() . '/includes/helpers.php';