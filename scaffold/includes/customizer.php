<?php

class Scaffold_Customizer
{
	function __construct( $customize )
	{
		$this->add_sections( $customize );
		$this->add_settings( $customize );
		$this->add_controls( $customize );
	}

	function add_sections( $customize )
	{
		// Layout
		$customize->add_section( 'scaffold_layout', array(
			'title'			=> __( 'Layout', SCAFFOLD_TEXTDOMAIN ),
			'priority'		=> 130
		) );
	}

	function add_settings( $customize )
	{
		// Site title
		$customize->add_setting( 'logo' );

		// Layout
		$customize->add_setting( 'scaffold_sidebar', array(
			'default'		=> 'sidebar_right'
		) );
	}

	function add_controls( $customize )
	{
		// Site title
		$customize->add_control( new WP_Customize_Image_Control( $customize, 'logo', array(
			'section'		=> 'title_tagline',
			'settings'		=> 'logo',
			'label'			=> __( 'Logo', SCAFFOLD_TEXTDOMAIN ),
			'priority'		=> 5
		) ) );

		// Layout
		$customize->add_control( 'scaffold_sidebar', array(
			'section'		=> 'scaffold_layout',
			'settings'		=> 'scaffold_sidebar',
			'label'			=> __( 'Sidebar', SCAFFOLD_TEXTDOMAIN ),
			'type'			=> 'radio',
			'choices'		=> array(
				'sidebar_right'		=> __( 'Sidebar Right', SCAFFOLD_TEXTDOMAIN ),
				'sidebar_left'		=> __( 'Sidebar Left', SCAFFOLD_TEXTDOMAIN ),
				'sidebar_none'		=> __( 'No Sidebar', SCAFFOLD_TEXTDOMAIN )
			)
		) );
	}
}