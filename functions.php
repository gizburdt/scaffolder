<?php

/*==================================================*/
/* Setup
/*==================================================*/
	
	add_action( 'after_setup_theme', 'scaffold_setup' );

	function scaffold_setup()
	{
		// Includes
		include( 'scaffold/scaffold.php' );
		include( 'includes/widgets/widget.php' );
		include( 'includes/walkers/walker-menu.php' );
		include( 'includes/walkers/walker-comment.php' );

		// Textdomain
		load_theme_textdomain( 'scaffold', get_template_directory() . '/languages' );

		// Theme support
		add_theme_support( 'menus' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

		// Image sizes
		/* set_post_thumbnail_size( 'width', 'height', 'crop' );
	
		add_image_size( 'name', width, height, true );
		add_image_size( 'name', width, height, true );
		add_image_size( 'name', width, height, true ); */

		// Editor
		add_editor_style( 'assets/css/editor-style.css' );
	}

	
/*==================================================*/
/* Hooks
/*==================================================*/
	
	if( ! is_admin() ) 
	{
		// Headers, footers, body
		add_filter( 'the_generator', 'remove_wp_version' );
		add_filter( 'body_class','browser_body_class' );
		add_filter( 'body_class','post_categories_body_class' );
		
		// Styles
		add_action( 'wp_enqueue_scripts', 'deregister_styles' );
		add_action( 'wp_enqueue_scripts', 'register_styles' );
		add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
		add_action( 'wp_head', 'add_specific_styles' );
		
		// Scripts
		add_action( 'wp_enqueue_scripts', 'deregister_scripts' );
		add_action( 'wp_enqueue_scripts', 'register_scripts' );
		add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
		
		// Login styles
		add_action( 'login_head', 'register_login_styles' );

		// Head
		add_action( 'wp_head', 'add_favicon' );
		
		// Excerpt
		add_filter( 'excerpt_length', 'excerpt_length' );
		add_filter( 'excerpt_more', 'excerpt_more' );

		// Menu
		add_filter( 'wp_nav_menu_objects', 'add_extra_menu_classes' );
	}
	else
	{
		// Styles
		add_action( 'admin_init', 'register_admin_styles' );
		add_action( 'admin_print_styles', 'enqueue_admin_styles' );
		
		// Scripts
		add_action( 'admin_init', 'register_admin_scripts' );
		add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );
		
		// Admin menu
		add_action( 'admin_menu', 'remove_menu_pages' );
		
		// Dashboard widgets
		add_action( 'wp_dashboard_setup', 'add_dashboard_widgets' );
		add_action( 'admin_menu', 'remove_dashboard_widgets' );
		
		// User
		add_filter( 'user_contactmethods', 'edit_contactmethods' );
	}
	
	// Widgets / Sidebars
	add_action( 'widgets_init', 'register_extra_sidebars' );
	add_action( 'widgets_init', 'register_widgets' );
	add_filter(' widget_text', 'do_shortcode' );
	
	// Menus
	add_action( 'init', 'register_menus' );


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
	    else               		$classes[] = 'unknown';

	    return $classes;  
	}
	
	// Post category name in body class
	function post_categories_body_class( $classes ) 
	{
	    if( ! is_single() )
	    {
	    	global $post;
	        foreach( ( get_the_category( $post->ID ) ) as $category ) 
			{  
	            $classes[] = 'term-' . $category->category_nicename;  
	        } 
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
		wp_register_style( 'normalize', get_template_directory_uri() . '/assets/css/normalize.css', '', '', 'screen' );
		wp_register_style( 'fonts', get_template_directory_uri() . '/assets/css/fonts.css', '', '', 'screen' );
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
		wp_enqueue_style( 'normalize' );
		wp_enqueue_style( 'fonts' );
		wp_enqueue_style( 'style' );
	}
	
	// Login screen styles
	function register_login_styles()
	{
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo( 'template_url' ) . '/assets/css/login.css">';
	}
	
	// Register admin styles
	function register_admin_styles()
	{
		wp_register_style( 'admin-style', get_template_directory_uri() . '/assets/css/admin.css', '', '', 'screen' );
	}
	
	// Enqueue / Print admin styles
	function enqueue_admin_styles()
	{
		// wp_enqueue_style( 'admin-style' );
	}

	// Add specific styles
	function add_specific_styles()
	{
		echo '<!--[if IE]><link rel="stylesheet" id="ie-7-css" href="' . get_template_directory_uri() . '/css/ie.css" type="text/css" media="screen"><![endif]-->';
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
		wp_register_script( 'html5', get_template_directory_uri() . '/assets/js/html5.min.js', '', '', true );
		wp_register_script( 'jquery-example', get_template_directory_uri() . '/assets/js/jquery.example.min.js', array( 'jquery' ), '', true);
		wp_register_script( 'jquery-masonry', get_template_directory_uri() . '/assets/js/jquery.masonry.min.js', array( 'jquery' ), '', true);
		wp_register_script( 'jquery-caroufredsel', get_template_directory_uri() . '/assets/js/jquery.caroufredsel.min.js', array( 'jquery' ), '', true);
		wp_register_script( 'functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery', 'jquery-ui-core', 'jquery-example', 'jquery-masonry', 'jquery-caroufredsel' ), '', true);
	}
	
	// Enqueue scripts
	function enqueue_scripts()
	{
		wp_enqueue_script( 'html5' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-example' );
		wp_enqueue_script( 'jquery-masonry' );
		wp_enqueue_script( 'jquery-caroufredsel' );
		wp_enqueue_script( 'functions' );

		if ( is_singular() && get_option( 'thread_comments' ) ) 
			wp_enqueue_script( 'comment-reply' );
	}
	
	function register_admin_scripts()
	{
		wp_register_script( 'admin-functions', get_template_directory_uri() . '/assets/js/admin.js' );
	}
	
	function enqueue_admin_scripts()
	{
		// wp_enqueue_script( 'admin-functions' );
	}

	
/*==================================================*/
/* Admin Menu
/*==================================================*/
	
	// Remove unnecessary pages
	function remove_menu_pages() 
	{
		remove_menu_page( 'link-manager.php' );
	}

	
/*==================================================*/
/*  Menu
/*==================================================*/
	
	// Register menus
	function register_menus()
	{
		register_nav_menus(
			array(
				'main-menu'			=> __( 'Main Menu', 'scaffold' ),
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
/* Dashboard widgets
/*==================================================*/
	
	// Add new dasboard widgets
	function add_dashboard_widgets() 
	{
		//wp_add_dashboard_widget( 'dashboard_widget', 'Dashboard Widget', 'dashboard_widget' );
	}

	function dashboard_widget() 
	{
		// echo '';
	}
	
	// Remove dashboard widgets
	function remove_dashboard_widgets() 
	{
		// Core
		// remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
		// remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
		
		// Yoast
		remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
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