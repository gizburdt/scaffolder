<?php

class Scaffold
{
	function __construct()
	{
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	function admin_menu()
	{
		add_theme_page( __( 'Customize' ), __( 'Customize' ), 'edit_theme_options', 'customize.php' );
	}

	function customize_register( $customize ) 
	{
		$this->add_sections( $customize );
		$this->add_settings( $customize );
		$this->add_controls( $customize );
	}

	function add_sections( $customize )
	{
		$customize->add_section( 'scaffold_text', array(
			'title'			=> __( 'Text' ),
			'priority'		=> 130,
		) );
	}

	function add_settings( $customize )
	{
		$customize->add_setting( 'text_color', array(
			'default'        => 'default_value',
		) );
	}

	function add_controls( $customize )
	{
		$customize->add_control( new WP_Customize_Color_Control( $customize, 'text_color', array(
			'label'   => 'Color Settscaffold_settingsing',
			'section' => 'scaffold_text',
			'settings'   => 'text_color',
		) ) );
	}
}

$scaffold = new Scaffold();

?>