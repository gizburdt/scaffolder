<?php

class Scaffold_Customizer
{
	function __construct()
	{
		add_action( 'customize_register', array( &$this, 'register' ) );
	}

	function register( $customize )
	{
		$this->add_sections( $customize );
		$this->add_settings( $customize );
		$this->add_controls( $customize );
	}

	function add_sections( $customize )
	{
		// Section
		$customize->add_section( 'section', array(
			'title'			=> __( 'Section', 'scaffold' ),
			'priority'		=> 130
		) );
	}

	function add_settings( $customize )
	{
		// Section
		$customize->add_setting( 'setting' );
	}

	function add_controls( $customize )
	{
		// Section
		$customize->add_control( 'setting', array(
			'section'  	=> 'section',
			'settings' 	=> 'setting',
			'label'   	=> 'Setting',
		));
	}
}

$customizer = new Scaffold_Customizer();