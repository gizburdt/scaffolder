<?php

/*==================================================*/
/* Breadcrumbs
/*==================================================*/

	function breadcrumbs() 
	{
		if ( ! is_front_page() ) 
		{
			echo '<p class="breadcrumbs"><a href="';
			echo get_option('home');
			echo '">';
			echo 'Home';
			echo "</a> &raquo; ";
		}

		if ( is_category() || is_single() ) {
			$category = get_the_category();
			echo get_category_parents( $category[0]->cat_ID, true, ' &raquo; ', false );
		}

		if( is_single() || is_page() ) echo '<span>' . get_the_title() . '</span>';
		if( is_tag() ) echo "Tag: ".single_tag_title( '',false );
		if( is_404() ) echo "404 - Page not Found";
		if( is_search() ) echo "Search";
		if( is_year() ) echo get_the_time('Y');

		echo "</p>";
	}

?>