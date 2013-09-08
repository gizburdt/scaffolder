<?php

	error_reporting( E_ALL );
	ini_set( 'display_errors', 1 );

/*==================================================*/
/* Setup
/*==================================================*/
	
	add_action( 'after_setup_theme', 'scaffold_setup' );

	function scaffold_setup()
	{
		// Includes
		include( 'includes/cuztom/cuztom.php' );
		include( 'includes/customize/customizer.php' );

		include( 'includes/walkers/walker-menu.php' );
		include( 'includes/walkers/walker-comment.php' );

		include( 'includes/widgets/widget.php' );

		// Textdomain
		load_theme_textdomain( 'scaffold', get_template_directory() . '/languages' );

		// Theme support
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( /* 'aside', 'link', 'gallery', 'status', 'quote', 'image' */ ) );

		// Image sizes	
		// add_image_size( 'name', width, height, true );

		// Editor
		add_editor_style( 'assets/css/editor-style.css' );
	}

	
/*==================================================*/
/* Hooks
/*==================================================*/
	
	if( ! is_admin() ) 
	{
		// Headers, footers, body
		add_filter( 'the_generator', 		'remove_wp_version' );
		add_filter( 'body_class', 			'browser_body_class' );
		add_filter( 'body_class', 			'post_categories_body_class' );
		add_action( 'wp_head', 				'add_favicon' );

		// Styles
		add_action( 'wp_enqueue_scripts', 	'deregister_styles' );
		add_action( 'wp_enqueue_scripts', 	'register_styles' );
		add_action( 'wp_enqueue_scripts', 	'enqueue_styles' );
		add_action( 'wp_head', 				'add_specific_styles' );
		// add_action( 'login_head', 		'register_login_styles' );
		
		// Scripts
		add_action( 'wp_enqueue_scripts', 	'deregister_scripts' );
		add_action( 'wp_enqueue_scripts', 	'register_scripts' );
		add_action( 'wp_enqueue_scripts', 	'enqueue_scripts' );
		
		// Excerpt
		add_filter( 'excerpt_length', 		'excerpt_length' );
		add_filter( 'excerpt_more', 		'excerpt_more' );

		// Menu
		add_filter( 'wp_nav_menu_objects', 	'add_extra_menu_classes' );
		add_filter( 'nav_menu_css_class', 	'fix_menu_class', 10, 2 );

		// SEO
		add_filter( 'wpseo_author_link', 	'no_author_on_pages' );
	}
	else
	{
		// Styles
		// add_action( 'admin_init', 			'register_admin_styles' );
		// add_action( 'admin_print_styles', 	'enqueue_admin_styles' );
		
		// Scripts
		// add_action( 'admin_init', 			'register_admin_scripts' );
		// add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );
		
		// Admin menu
		add_action( 'admin_menu', 			'remove_menu_pages' );
		
		// Dashboard widgets
		add_action( 'wp_dashboard_setup', 	'remove_dashboard_widgets' );
		add_action( 'wp_dashboard_setup', 	'add_dashboard_widgets' );
		
		// User
		add_filter( 'user_contactmethods', 	'edit_contactmethods' );

		// Misc
		add_filter( 'mce_buttons', 			'enable_more_buttons' );
	}
	
	// Widgets / Sidebars
	add_action( 'widgets_init', 		'register_extra_sidebars' );
	add_action( 'widgets_init', 		'register_widgets' );
	add_filter(' widget_text', 			'do_shortcode' );
	
	// Menus
	add_action( 'init', 				'register_menus' );

	// Mail
	add_filter( 'wp_mail_from', 		'new_mail_from' );
	add_filter( 'wp_mail_from_name', 	'new_mail_from_name' );


/*==================================================*/
/* Headers, footers, body
/*==================================================*/
	
	function remove_wp_version() 
	{
		return '';
	}
	
	// Browser name in body class
	function browser_body_class( $classes ) 
	{
	    global $is_gecko, $is_IE, $is_opera, $is_safari, $is_chrome;  

	    if( $is_gecko )      	$classes[] = 'gecko';  
	    elseif( $is_opera )  	$classes[] = 'opera';  
	    elseif( $is_safari )	$classes[] = 'safari';  
	    elseif( $is_chrome )	$classes[] = 'chrome';  
	    elseif( $is_IE )		$classes[] = 'ie';  
	    else               		$classes[] = 'unknown-browser';

	    return $classes;  
	}
	
	// Post category name in body class
	function post_categories_body_class( $classes ) 
	{
	    if( is_single() )
	    {
	    	global $post;
	        foreach( ( get_the_category( $post->ID ) ) as $category ) 
	            $classes[] = 'term-' . $category->category_nicename;
	    }

	    return $classes;
	}

	// Favicon
	function add_favicon()
	{
		echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/assets/images/favicon.ico" type="image/x-icon">';
	}


/*==================================================*/
/* Styles
/*==================================================*/
	
	// Register styles
	function register_styles()
	{
		wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', '', '', 'screen' );
		wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', '', '', 'screen' );
		wp_register_style( 'fancybox', get_template_directory_uri() . '/assets/css/fancybox.css', '', '', 'screen' );
		wp_register_style( 'style', get_template_directory_uri() . '/style.css', '', '', 'screen' );
	}
	
	// Deregister styles
	function deregister_styles()
	{
		// wp_deregister_style();
	}
	
	// Enqueue styles
	function enqueue_styles()
	{
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'fancybox' );
		wp_enqueue_style( 'style' );
	}
	
	// Login screen styles
	function register_login_styles()
	{
		echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/assets/css/login.css">';
	}
	
	// Register admin styles
	function register_admin_styles()
	{
		wp_register_style( 'admin-style', get_template_directory_uri() . '/assets/css/admin.css', '', '', 'screen' );
	}
	
	// Enqueue / Print admin styles
	function enqueue_admin_styles()
	{
		wp_enqueue_style( 'admin-style' );
	}

	// Add specific styles
	function add_specific_styles()
	{
		echo '<!--[if lt IE9]><link rel="stylesheet" id="ie-css" href="' . get_template_directory_uri() . '/css/ie.css" type="text/css" media="screen"><![endif]-->';
	}


/*==================================================*/
/* Scripts
/*==================================================*/
	
	// Deregister scripts
	function deregister_scripts()
	{
	}
	
	// Register scripts
	function register_scripts() 
	{
		wp_register_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.min.js', '', '', true );
		wp_register_script( 'respond', get_template_directory_uri() . '/assets/js/respond.min.js', '', '', true );
		wp_register_script( 'enquire', get_template_directory_uri() . '/assets/js/enquire.min.js', '', '', true );
		
		wp_register_script( 'jquery-fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'jquery-example', get_template_directory_uri() . '/assets/js/jquery.example.min.js', array( 'jquery' ), '', true);
		wp_register_script( 'jquery-caroufredsel', get_template_directory_uri() . '/assets/js/jquery.caroufredsel.min.js', array( 'jquery' ), '', true);
		wp_register_script( 'jquery-fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array( 'jquery' ), '', true);
		
		wp_register_script( 'functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs' ), '', true);
	}
	
	// Enqueue scripts
	function enqueue_scripts()
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

		localize_scripts();
	}
	
	function register_admin_scripts()
	{
		wp_register_script( 'admin-functions', get_template_directory_uri() . '/assets/js/admin.js' );
	}
	
	function enqueue_admin_scripts()
	{
		wp_enqueue_script( 'admin-functions' );
	}

	// Localise scripts
	function localize_scripts()
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
	function register_extra_sidebars()
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
	function register_widgets()
	{
		// register_widget( 'Widget' );
	}
	
/*==================================================*/
/*  Menu
/*==================================================*/
	
	// Register menus
	function register_menus()
	{
		register_nav_menus(
			array(
				'primary'			=> __( 'Primary', 'scaffold' ),
				// 'top-menu'		=> __( 'Top Menu', 'scaffold' ),
				// 'footer-menu'	=> __( 'Footer Menu', 'scaffold' )
			)
		);
	}

	// Add extra (first, last) classes to menu items
	function add_extra_menu_classes( $objects ) 
	{
	    $objects[1]->classes[] = 'first';
	    $objects[count( $objects )]->classes[] = 'last';

	    return $objects;
	}

	// Fix menu, so the page_for_posts page won't highlight on post type archive
	function fix_menu_class( $classes = array(), $item = false )
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

	function excerpt_length( $length ) 
	{
		return 55;
	}
	
	function excerpt_more( $more ) 
	{
		return ' [...]';
	}

/*==================================================*/
/* Admin
/*==================================================*/
	
	// Remove unnecessary pages
	function remove_menu_pages() 
	{
		remove_menu_page( 'link-manager.php' );
	}

	// Add new dasboard widgets
	function add_dashboard_widgets() 
	{
		// wp_add_dashboard_widget( 'dashboard_widget', 'Dashboard Widget', 'dashboard_widget' );
	}
	
	// Remove dashboard widgets
	function remove_dashboard_widgets() 
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
	function edit_contactmethods( $methods )
	{
		unset( $methods['aim'] );
		unset( $methods['jabber'] );
		unset( $methods['yim'] );
		
		return $methods;
	}

/*==================================================*/
/* Mail
/*==================================================*/

	function new_mail_from( $email ) 
	{
	    $email = get_bloginfo( 'admin_email' );
	 
	    return $email;
	}

	function new_mail_from_name( $name ) {
	    $name = get_bloginfo( 'name' );
	 
	    return $name;
	}

/*==================================================*/
/* Misc
/*==================================================*/

	function enable_more_buttons( $buttons ) 
	{
		$buttons[] = 'hr';

		return $buttons;
	}

	// SEO Yoast, no author on pages
	function no_author_on_pages( $gplus )
	{
		if( ! is_singular('post') ) return '';

		return $gplus;
	}

/*==================================================*/
/* Pagination
/*==================================================*/
	
	// Pagination helper function
	function pagination( $pages = '', $range = 2 )
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
	