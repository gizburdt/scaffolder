<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<title><?php scaffold_title(); ?></title>
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<!-- BEGIN #wrapper -->
	<div id="wrapper">
		
		<div id="header_wrap">
			<div id="header">
				
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo"></a>
				
				<?php 
				
					wp_nav_menu( array(
						'theme_location'	=> 'main_menu',
						'container_class'	=> 'main_menu',
						'container_id'		=> 'main_menu',
						'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           	=> 0,
						'walker'         	=> ''
					) ); 
					
					// OR
					// get_search_form();
					
				?>
				
				
			</div>
		</div>