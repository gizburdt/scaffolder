<?php

/*==================================================*/
/* Defines, includes, startup
/*==================================================*/
	
	define( 'SCAFFOLD_TEXTDOMAIN', 'scaffold' );
	
	//include( 'scaffold/scaffold.php' );
	
	include( 'includes/widgets/widget.php' );
	
	include( 'includes/walkers/menu_walker.php' );
	include( 'includes/walkers/comment_walker.php' );
	
	include( 'includes/functions/breadcrumbs.php' );
	include( 'includes/functions/meta_boxes.php' );
	include( 'includes/functions/pagination.php' );
	include( 'includes/functions/shortcodes.php' );
	
	load_theme_textdomain( SCAFFOLD_TEXTDOMAIN, get_template_directory() . '/languages' );
	
	
/*==================================================*/
/* Theme Support
/*==================================================*/
	
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	//add_theme_support( 'custom-background' );
	//add_theme_support( 'custom-header' );
	
	/*add_theme_support( 'post-formats', array( 
		'aside', 
		'link', 
		'gallery', 
		'status', 
		'quote', 
		'image' 
	) );*/
	
	
/*==================================================*/
/* Image sizes
/*==================================================*/
	
	//set_post_thumbnail_size( 'width', 'height', 'crop' );
	
	//add_image_size( 'name', width, height, true );
	//add_image_size( 'name', width, height, true );
	//add_image_size( 'name', width, height, true );
	
	
/*==================================================*/
/* Actions
/*==================================================*/
	
	if( ! is_admin() ) 
	{
		// Headers, footers, body
		add_filter( 'the_generator', 'remove_wp_version' );
		add_filter( 'body_class','browser_body_class' );
		add_filter( 'body_class','post_categories_body_class' );
		
		// Styles
		add_action( 'init', 'deregister_styles' );
		add_action( 'init', 'register_styles' );
		add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
		
		// Scripts
		add_action( 'init', 'deregister_scripts' );
		add_action( 'init', 'register_scripts' );
		add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
		
		// Login styles
		add_action( 'login_head', 'register_login_styles' );
		
		// Excerpt
		add_filter( 'excerpt_length', 'excerpt_length' );
		add_filter( 'excerpt_more', 'excerpt_more' );
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
	    if( is_single() ) 
		{
	        global $post;
	        foreach( ( get_the_category( $post->ID ) ) as $category ) 
			{  
	            $classes[] = 'term-' . $category->category_nicename;  
	        }  
	    }  

	    return $classes;
	}  
	
	

/*==================================================*/
/* Styles
/*==================================================*/
	
	// Register styles
	function register_styles()
	{
		wp_register_style( 'reset', get_template_directory() . '/assets/css/reset.css', '', '', 'screen' );
		wp_register_style( 'fonts', get_template_directory() . '/assets/css/fonts.css', '', '', 'screen' );
		wp_register_style( 'style', get_template_directory() . '/style.css', '', '', 'screen' );
	}
	
	// Deregister styles
	function deregister_styles()
	{
		//wp_deregister_style();
	}
	
	// Enqueue styles
	function enqueue_styles()
	{
		wp_enqueue_style( 'reset' );
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
		wp_register_style( 'admin-style', get_template_directory() . '/assets/css/admin.css', '', '', 'screen' );
	}
	
	// Enqueue / Print admin styles
	function enqueue_admin_styles()
	{
		wp_enqueue_style( 'admin-style' );
	}


/*==================================================*/
/* Scripts
/*==================================================*/
	
	// Deregister scripts
	function deregister_scripts()
	{
		//wp_deregister_script( 'jquery' );
		//wp_deregister_script( 'jquery-ui-core' );
	}
	
	// Register scripts
	function register_scripts() 
	{
		wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', '', '', true );
		wp_register_script( 'jquery-ui-core', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js', array( 'jquery' ), '', true );
		wp_register_script( 'functions', get_template_directory() . '/assets/js/functions.js', array( 'jquery' ), '', true);
	}
	
	// Enqueue scripts
	function enqueue_scripts()
	{
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'functions' );
	}
	
	function register_admin_scripts()
	{
		wp_register_script( 'admin-functions', get_template_directory() . '/assets/js/admin.js' );
	}
	
	function enqueue_admin_scripts()
	{
		wp_enqueue_script( 'admin-functions' );
	}
	
	
/*==================================================*/
/* Admin Menu
/*==================================================*/
	
	// Remove unnecessary pages
	function remove_menu_pages() 
	{
		remove_menu_page('link-manager.php');
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
		return '[...]';
	}
	

/*==================================================*/
/* Sidebars, widgets
/*==================================================*/
	
	function register_extra_sidebars()
	{
		/*
		register_sidebar( array(
			'name' 			=> 'sidebar',
			'id'			=> 'sidebar',
			'description'	=> __( 'Just a sidebar', SCAFFOLD_TEXTDOMAIN ),
		) );
		*/
	}
	
	// Register widgets
	function register_widgets()
	{
		register_widget('Widget');
	}
	
	
/*==================================================*/
/* Dashboard widgets
/*==================================================*/

	function add_dashboard_widgets() 
	{
		wp_add_dashboard_widget( 'dashboard_widget', 'Dashboard Widget', 'dashboard_widget' );
	}

	function dashboard_widget() 
	{
		echo 'Dashboard widget';
	}
	
	function remove_dashboard_widgets() 
	{
		// Core
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
		
		// Yoast
		remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
	}
	

/*==================================================*/
/* User
/*==================================================*/

	function edit_contactmethodes( $methods )
	{
		unset( $contactmethods['aim'] );
		unset( $contactmethods['jabber'] );
		unset( $contactmethods['yim'] );
		
		return $methods;
	}
	
?>