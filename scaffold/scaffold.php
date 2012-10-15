<?php

/*==================================================*/
/* Includes, defines, start
/*==================================================*/
	
	ob_start();

	define( 'ACTIVATE_SCAFFOLD', true );

	if( ACTIVATE_SCAFFOLD )
	{
		include( 'includes/customizer.php' );

		$scaffold = new Scaffold();
	}


/*==================================================*/
/* Scaffold
/*==================================================*/

	class Scaffold
	{
		function __construct()
		{
			add_action( 'after_setup_theme', array( &$this, 'after_theme_setup' ) );

			add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
			add_action( 'customize_register', array( &$this, 'customize_register' ) );			
		}

		function after_theme_setup()
		{
			set_theme_mod( 'scaffold_sidebar', 'sidebar_right' );
		}

		function admin_menu()
		{
			add_theme_page( __( 'Customize' ), __( 'Customize' ), 'edit_theme_options', 'customize.php' );
		}		

		function customize_register( $customize ) 
		{
			$customizer = new Scaffold_Customizer( $customize );
		}
	}