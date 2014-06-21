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
    if( empty( $paged ) ) {
        $paged = 1;
    }

    if( $pages == '' ) {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if( ! $pages ) {
            $pages = 1;
        }
    }

    if( 1 != $pages ) {
        echo '<div class="pagination">';
            if( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
                echo '<a href="' . get_pagenum_link( 1 ) . '">&laquo;</a>';
            }

            if( $paged > 1 && $showitems < $pages ) {
                echo '<a href="' . get_pagenum_link( $paged - 1 ) . '">&lsaquo;</a>';
            }

            for ( $i = 1; $i <= $pages; $i++ ) {
                if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems )) {
                    echo ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '" class="inactive" >' . $i . '</a>';
                }
            }

            if ( $paged < $pages && $showitems < $pages ) {
                echo '<a href="' . get_pagenum_link( $paged + 1 ) . '">&rsaquo;</a>';  
            }
            
            if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
                echo '<a href="' . get_pagenum_link($pages) . '">&raquo;</a>';
            }
        echo '</div>';
     }
}

/**
 * Inserts a new key/value before the key in the array.
 *
 * @param $key The key to insert before.
 * @param $array An array to insert in to.
 * @param $new_key The key to insert.
 * @param $new_value An value to insert.
 *
 * @return The new array if the key exists, FALSE otherwise.
 *
 * @see array_insert_after()
 */
function array_insert_before( $key, array &$array, $new_key, $new_value ) 
{
    if (array_key_exists($key, $array)) {
        $new = array();
        foreach ($array as $k => $value) {
            if ($k === $key) {
                $new[$new_key] = $new_value;
            }
        
            $new[$k] = $value;
        }
        return $new;
    }

    return false;
}

/**
 * Inserts a new key/value after the key in the array.
 *
 * @param $key The key to insert after.
 * @param $array An array to insert in to.
 * @param $new_key The key to insert.
 * @param $new_valueAn value to insert.
 *
 * @return The new array if the key exists, FALSE otherwise.
 *
 * @see array_insert_before()
 */
function array_insert_after( $key, array &$array, $new_key, $new_value ) 
{
    if (array_key_exists($key, $array)) {
        $new = array();
        foreach ($array as $k => $value) {
            $new[$k] = $value;
            if ($k === $key) {
                $new[$new_key] = $new_value;
            }
        }
        return $new;
    }
    
    return false;
}