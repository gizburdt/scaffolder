<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Comments nav.
 */
function scaffolder_comment_nav()
{
    if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php _e('Comment navigation', 'scaffolder'); ?></h1>
            <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'scaffolder')); ?></div>
            <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'scaffolder')); ?></div>
        </nav>
    <?php endif;
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
function array_insert_before($key, array &$array, $new_key, $new_value)
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
function array_insert_after($key, array &$array, $new_key, $new_value)
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

/**
 * Flattens a multi-dimensional array to a normal array.
 *
 * @param $array Multidimensional array
 *
 * @return The new array
 */
function array_flatten($array)
{
    if (! is_array($array)) {
        return false;
    }

    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[$key] = $value;
        }
    }

    return $result;
}

/**
 * Check scaffolder env.
 * @param  string $env
 * @return bool
 */
function is_scaffolder_env($env)
{
    return SCAFFOLDER_ENV == $env;
}
