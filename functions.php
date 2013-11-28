<?php

// Error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

// Block direct access
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Scaffold' ) ) :

	// Set content_width
	if ( ! isset( $content_width ) )
		$content_width = 640;

	// Assets dir (composer stuff)
	if( ! defined( 'CUZTOM_VENDOR_URI' ) )
		define( 'CUZTOM_VENDOR_URI', WP_CONTENT_DIR . '/vendor' );

	/**
	 * Scaffold class
	 */
	class Scaffold
	{
		function __construct()
		{
			add_action( 'sfter_theme_setup', 	array( &$this, 'setup_theme' ) );
			add_action( 'init', 				array( &$this, 'includes' ) );
			add_action( 'init', 				array( &$this, 'add_hooks' ) );
			add_action( 'init', 				array( &$this, 'add_admin_hooks' ) );
		}

		function includes()
		{
			// Customizer
			include( 'includes/customize/customizer.php' );

			// Walkers
			include( 'includes/walkers/walker-menu.php' );
			include( 'includes/walkers/walker-comment.php' );

			// Widgets
			include( 'includes/widgets/widget.php' );
		}

		function setup_theme()
		{
			// Textdomain
			load_theme_textdomain( 'scaffold', get_template_directory() . '/languages' );

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
				'footer-menu'		=> __( 'Footer Menu', 'scaffold' )
			) );

			// Widgets
			add_action( 'widgets_init', 		'scaffold_register_extra_sidebars' );
			add_action( 'widgets_init', 		'scaffold_register_widgets' );
			add_filter( 'widget_text', 			'do_shortcode' );

			// Mail
			add_filter( 'wp_mail_from', 		'scaffold_new_mail_from' );
			add_filter( 'wp_mail_from_name', 	'scaffold_new_mail_from_name' );

			// Misc
			// add_filter( 'use_default_gallery_style', '__return_false' );
		}

		function add_hooks()
		{
			// Headers, footers, body
			add_filter( 'the_generator', 		'scaffold_remove_wp_version' );
			add_filter( 'body_class', 			'scaffold_body_class' );
			add_filter( 'wp_title', 			'scaffold_wp_title', 10, 2 );
			add_action( 'wp_head', 				'scaffold_favicon' );

			// Styles
			add_action( 'wp_enqueue_scripts', 	'scaffold_deregister_styles' );
			add_action( 'wp_enqueue_scripts', 	'scaffold_register_styles' );
			add_action( 'wp_enqueue_scripts', 	'scaffold_enqueue_styles' );
			add_action( 'wp_head', 				'scaffold_add_specific_styles' );
			add_action( 'login_head', 			'scaffold_register_login_styles' );
			
			// Scripts
			add_action( 'wp_enqueue_scripts', 	'scaffold_deregister_scripts' );
			add_action( 'wp_enqueue_scripts', 	'scaffold_register_scripts' );
			add_action( 'wp_enqueue_scripts', 	'scaffold_enqueue_scripts' );
			
			// Excerpt
			add_filter( 'excerpt_length', 		'scaffold_excerpt_length' );
			add_filter( 'excerpt_more', 		'scaffold_excerpt_more' );

			// Menu
			add_filter( 'wp_nav_menu_objects', 	'scaffold_add_extra_menu_classes' );
			add_filter( 'nav_menu_css_class', 	'scaffold_fix_menu_class', 10, 2 );

			// SEO
			add_filter( 'wpseo_author_link', 	'scaffold_no_author_on_pages' );
		}

		function add_admin_hooks()
		{
			if( is_admin() )
			{
				// Styles
				// add_action( 'admin_init', 			'scaffold_register_admin_styles' );
				// add_action( 'admin_print_styles', 	'scaffold_enqueue_admin_styles' );
				
				// Scripts
				// add_action( 'admin_init', 			'scaffold_register_admin_scripts' );
				// add_action( 'admin_enqueue_scripts', 'scaffold_enqueue_admin_scripts' );
				
				// Admin menu
				add_action( 'admin_menu', 			'scaffold_remove_menu_pages' );
				
				// Dashboard widgets
				add_action( 'wp_dashboard_setup', 	'scaffold_remove_dashboard_widgets' );
				add_action( 'wp_dashboard_setup', 	'scaffold_add_dashboard_widgets' );
				
				// User
				add_filter( 'user_contactmethods', 	'scaffold_edit_contactmethods' );

				// Misc
				add_filter( 'mce_buttons', 			'scaffold_enable_more_buttons' );
			}
		}
	}

/*==================================================*/
/* Headers, footers, body
/*==================================================*/
	
	function scaffold_remove_wp_version() 
	{
		return '';
	}
	
	// Browser name in body class
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

	// Favicon
	function scaffold_favicon()
	{
		echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/assets/images/favicon.ico" type="image/x-icon">';
	}

	// Title
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


/*==================================================*/
/* Styles
/*==================================================*/
	
	// Deregister styles
	function scaffold_deregister_styles()
	{
		// wp_deregister_style();
	}

	// Register styles
	function scaffold_register_styles()
	{
		// Vendor
		wp_register_style( 'bootstrap', CUZTOM_VENDOR_URI . '/twbs/bootstrap/dist/css/bootstrap.min.css', '', '', 'screen' );
		wp_register_style( 'font-awesome', CUZTOM_VENDOR_URI . '/components/font-awesome/css/font-awesome.min.css', '', '', 'screen' );
		wp_register_style( 'fancybox', CUZTOM_VENDOR_URI . '/fancyapps/fancybox/source/jquery.fancybox.css', '', '', 'screen' );
		
		// Theme
		wp_register_style( 'style', get_template_directory_uri() . '/style.css', '', '', 'screen' );
	}	
	
	// Enqueue styles
	function scaffold_enqueue_styles()
	{
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'fancybox' );
		wp_enqueue_style( 'style' );
	}
	
	// Login screen styles
	function scaffold_register_login_styles()
	{
		echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/assets/css/login.css">';
	}
	
	// Register admin styles
	function scaffold_register_admin_styles()
	{
		wp_register_style( 'admin-style', get_template_directory_uri() . '/assets/css/admin.css', '', '', 'screen' );
	}
	
	// Enqueue / Print admin styles
	function scaffold_enqueue_admin_styles()
	{
		wp_enqueue_style( 'admin-style' );
	}

	// Add specific styles
	function scaffold_add_specific_styles()
	{
		echo '<!--[if lt IE9]><link rel="stylesheet" id="ie-css" href="' . get_template_directory_uri() . '/css/ie.css" type="text/css" media="screen"><![endif]-->';
	}


/*==================================================*/
/* Scripts
/*==================================================*/
	
	// Deregister scripts
	function scaffold_deregister_scripts()
	{
	}
	
	// Register scripts
	function scaffold_register_scripts() 
	{
		// Vendor
		wp_register_script( 'bootstrap', CUZTOM_VENDOR_URI . '/twbs/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'modernizr', CUZTOM_VENDOR_URI . '/components/modernizr/modernizr.js', '', '', true );
		wp_register_script( 'respond', CUZTOM_VENDOR_URI . '/scottjehl/respond/respond.min.js', '', '', true );
		wp_register_script( 'enquire', CUZTOM_VENDOR_URI . '/wickynilliams/enquire/dist/enquire.min.js', '', '', true );
		wp_register_script( 'jquery-fancybox', CUZTOM_VENDOR_URI . '/fancyapps/fancybox/source/jquery.fancybox.pack.js', array( 'jquery' ), '', true);
		
		// Assets
		wp_register_script( 'jquery-fitvids', CUZTOM_VENDOR_URI . '/davatron5000/fitvids/jquery.fitvids.js', array( 'jquery' ), '', true );
		wp_register_script( 'jquery-example', CUZTOM_VENDOR_URI . '/mudge/example/jquery.example.min.js', array( 'jquery' ), '', true);
		wp_register_script( 'jquery-caroufredsel', CUZTOM_VENDOR_URI . '/gilbitron/caroufredsel/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ), '', true);

		// Theme
		wp_register_script( 'functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs' ), '', true);
	}
	
	// Enqueue scripts
	function scaffold_enqueue_scripts()
	{
		wp_enqueue_script( 'jquery', '/wp-includes/js/jquery/jquery.js', null, null, false );

		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'modernizr' );
		wp_enqueue_script( 'respond' );
		wp_enqueue_script( 'enquire' );		

		wp_enqueue_script( 'jquery-fitvids' );
		wp_enqueue_script( 'jquery-example' );
		wp_enqueue_script( 'jquery-caroufredsel' );
		wp_enqueue_script( 'jquery-fancybox' );
		
		wp_enqueue_script( 'functions' );

		if ( is_singular() && get_option( 'thread_comments' ) ) 
			wp_enqueue_script( 'comment-reply' );

		scaffold_localize_scripts();
	}
	
	// Register admin scripts
	function scaffold_register_admin_scripts()
	{
		wp_register_script( 'admin-functions', get_template_directory_uri() . '/assets/js/admin.js' );
	}
	
	// Enqueue admin scripts
	function scaffold_enqueue_admin_scripts()
	{
		wp_enqueue_script( 'admin-functions' );
	}

	// Localise scripts
	function scaffold_localize_scripts()
	{
		wp_localize_script( 'functions', 'Scaffold', array(
			'template_uri'		=> get_template_directory_uri(),
			'home_url'			=> get_home_url(),
			'ajax_url'			=> admin_url( 'admin-ajax.php' )
		) );
	}

/*==================================================*/
/* Sidebars, widgets
/*==================================================*/
	
	// Register sidebars
	function scaffold_register_extra_sidebars()
	{
		register_sidebar( array(
			'name' 			=> 'sidebar',
			'id'			=> 'sidebar',
			'description'	=> __( 'Just a sidebar', 'scaffold' ),
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	
	// Register widgets
	function scaffold_register_widgets()
	{
		// register_widget( 'Widget' );
	}
	
/*==================================================*/
/*  Menu
/*==================================================*/

	// Add extra (first, last) classes to menu items
	function scaffold_add_extra_menu_classes( $objects ) 
	{
	    $objects[1]->classes[] = 'first';
	    $objects[count( $objects )]->classes[] = 'last';

	    return $objects;
	}

	// Fix menu, so the page_for_posts page won't highlight on post type archive
	function scaffold_fix_menu_class( $classes = array(), $item = false )
	{
		$post_types = get_post_types( array( '_builtin' => false ) );
		$home 		= get_option( 'page_for_posts' );
		
		if ( is_singular( $post_types ) || is_post_type_archive( $post_types ) || is_author() || is_404() )
		{
			if( $home == $item->object_id )
			{
				if( in_array( 'current_page_parent', $classes ) )
					unset( $classes[array_search( 'current_page_parent', $classes )] );
			}

			if( is_singular() )
			{
				global $post;
				$post_type = get_post_type( $post->ID );

				if( in_array( 'archive_' . $post_type, $classes ) )
				{
					$classes[] = 'current_page_parent';
				}
			}
		}

		return $classes;
	}

/*==================================================*/
/* Excerpt
/*==================================================*/

	function scaffold_excerpt_length( $length ) 
	{
		return 55;
	}
	
	function scaffold_excerpt_more( $more ) 
	{
		return ' [...]';
	}

/*==================================================*/
/* Admin
/*==================================================*/
	
	// Remove unnecessary pages
	function scaffold_remove_menu_pages() 
	{
		remove_menu_page( 'link-manager.php' );
	}

	// Add new dasboard widgets
	function scaffold_add_dashboard_widgets() 
	{
		// wp_add_dashboard_widget( 'dashboard_widget', 'Dashboard Widget', 'dashboard_widget' );
	}
	
	// Remove dashboard widgets
	function scaffold_remove_dashboard_widgets() 
	{
		global $wp_meta_boxes;

		// Core
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
		// unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] );
		// unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
		
		// Yoast
		unset( $wp_meta_boxes['dashboard']['side']['core']['yoast_db_widget'] );
	}

/*==================================================*/
/* User
/*==================================================*/
	
	// Remove unneccesary contactmethods
	function scaffold_edit_contactmethods( $methods )
	{
		unset( $methods['aim'] );
		unset( $methods['jabber'] );
		unset( $methods['yim'] );
		
		return $methods;
	}

/*==================================================*/
/* Mail
/*==================================================*/

	function scaffold_new_mail_from( $email ) 
	{
	    $email = get_bloginfo( 'admin_email' );
	 
	    return $email;
	}

	function scaffold_new_mail_from_name( $name ) {
	    $name = get_bloginfo( 'name' );
	 
	    return $name;
	}

/*==================================================*/
/* Misc
/*==================================================*/

	function scaffold_enable_more_buttons( $buttons ) 
	{
		$buttons[] = 'hr';

		return $buttons;
	}

	// SEO Yoast, no author on pages
	function scaffold_no_author_on_pages( $gplus )
	{
		if( ! is_singular('post') ) return '';

		return $gplus;
	}

/*==================================================*/
/* Pagination
/*==================================================*/
	
	// Pagination helper function
	function scaffold_pagination( $pages = '', $range = 2 )
	{  
	     $showitems = ( $range * 2 ) + 1;

	     global $paged;
	     if( empty( $paged ) ) $paged = 1;

	     if( $pages == '' )
	     {
	         global $wp_query;
	         $pages = $wp_query->max_num_pages;
	         if( ! $pages )
	         {
	             $pages = 1;
	         }
	     }   

	     if( 1 != $pages )
	     {
	         echo '<div class="pagination">';
	         if( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) echo '<a href="' . get_pagenum_link( 1 ) . '">&laquo;</a>';
	         if( $paged > 1 && $showitems < $pages) echo '<a href="' . get_pagenum_link( $paged - 1 ) . '">&lsaquo;</a>';

	         for ( $i = 1; $i <= $pages; $i++ )
	         {
	             if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ))
	             {
	                 echo ( $paged == $i ) ? '<span class="current">' . $i . '</span>'
						: '<a href="' . get_pagenum_link( $i ) . '" class="inactive" >' . $i . '</a>';
	             }
	         }

	         if ( $paged < $pages && $showitems < $pages) echo '<a href="' . get_pagenum_link( $paged + 1 ) . '">&rsaquo;</a>';  
	         if ( $paged < $pages - 1 && $paged+$range - 1 < $pages && $showitems < $pages ) 
				echo '<a href="' . get_pagenum_link($pages) . '">&raquo;</a>';
	         echo '</div>';
	     }
	}

endif; // Endif class_exists check

$scaffold = new Scaffold();
