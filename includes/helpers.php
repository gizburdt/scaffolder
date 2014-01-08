<?php

// Block direct access
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Helper function to generate normal pagination
 */
function scaffold_paging_nav( $pages = '', $range = 2 )
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

/**
 * Display navigation to next/previous post when applicable.
 * Props to _s
 *
 * @return void
 */
function scaffold_post_nav() 
{
    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous ) {
        return;
    }
    
    ?>
    <nav class="navigation post-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'scaffold' ); ?></h1>
        <div class="nav-links">
            <?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'scaffold' ) ); ?>
            <?php next_post_link(     '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'scaffold' ) ); ?>
        </div>
    </nav>
    <?php
}