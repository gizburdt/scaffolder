<?php

// Block direct access
if( ! defined( 'ABSPATH' ) ) exit;

// Set content_width
if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

// Assets/vendor dir
if( ! defined( 'SCAFFOLD_VENDOR_DIR' ) ) {
	define( 'SCAFFOLD_VENDOR_DIR', WP_CONTENT_URL . '/vendor' );
}


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
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// Image sizes	
	// add_image_size( 'name', width, height, true );

	// Editor
	add_editor_style( 'assets/css/editor-style.css' );

	// Menus
	register_nav_menus( array(
		'primary-menu'		=> __( 'Primary', 'scaffold' ),
		'secondary-menu'	=> __( 'Secondary', 'scaffold' ),
		'footer-menu'		=> __( 'Footer Menu', 'scaffold' )
	) );

	// Widgets
	add_action( 'widgets_init', 		'scaffold_register_extra_sidebars' );
	add_action( 'widgets_init', 		'scaffold_register_widgets' );
}
endif;
add_action( 'after_theme_setup', 'scaffold_setup' );

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
	wp_register_style( 'bootstrap', SCAFFOLD_VENDOR_DIR . '/twbs/bootstrap/dist/css/bootstrap.min.css', '', '', 'screen' );
	wp_register_style( 'fancybox', SCAFFOLD_VENDOR_DIR . '/fancyapps/fancybox/source/jquery.fancybox.css', '', '', 'screen' );
	
	// Theme
	wp_register_style( 'style', get_stylesheet_directory_uri() . '/style.css', '', '', 'screen' );
}

/**
 * Enqueue styles.
 */
function scaffold_enqueue_styles()
{
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'fancybox' );
	wp_enqueue_style( 'style' );
}

/**
 * Register scripts
 */
function scaffold_register_scripts() 
{
	// Vendor
	wp_register_script( 'bootstrap', SCAFFOLD_VENDOR_DIR . '/twbs/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '', true );
	wp_register_script( 'modernizr', SCAFFOLD_VENDOR_DIR . '/components/modernizr/modernizr.js', '', '', true );
	wp_register_script( 'respond', SCAFFOLD_VENDOR_DIR . '/scottjehl/respond/dest/respond.min.js', '', '', true );
	wp_register_script( 'enquire', SCAFFOLD_VENDOR_DIR . '/wickynilliams/enquire/dist/enquire.min.js', '', '', true );
	wp_register_script( 'jquery-fancybox', SCAFFOLD_VENDOR_DIR . '/fancyapps/fancybox/source/jquery.fancybox.pack.js', array( 'jquery' ), '', true);
	wp_register_script( 'jquery-fitvids', SCAFFOLD_VENDOR_DIR . '/davatron5000/fitvids/jquery.fitvids.js', array( 'jquery' ), '', true );
	wp_register_script( 'jquery-example', SCAFFOLD_VENDOR_DIR . '/mudge/example/jquery.example.min.js', array( 'jquery' ), '', true);
	wp_register_script( 'jquery-caroufredsel', SCAFFOLD_VENDOR_DIR . '/gilbitron/caroufredsel/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ), '', true);
}

/**
 * Enqueue scripts
 */
function scaffold_enqueue_scripts()
{
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'modernizr' );
	wp_enqueue_script( 'respond' );
	wp_enqueue_script( 'enquire' );		
	wp_enqueue_script( 'jquery-fitvids' );
	wp_enqueue_script( 'jquery-example' );
	wp_enqueue_script( 'jquery-caroufredsel' );
	wp_enqueue_script( 'jquery-fancybox' );

	if ( is_singular() && get_option( 'thread_comments' ) ) 
		wp_enqueue_script( 'comment-reply' );
}

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

