<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<title>
		<?php
		
			global $page, $paged;

			wp_title( '|', true, 'right' );
			bloginfo( 'name' );

			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) ) echo ' |' . $site_description;
			if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', SCAFFOLD_TEXTDOMAIN ), max( $paged, $page ) );

		?>
	</title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<!-- BEGIN #wrapper -->
	<div id="wrapper">