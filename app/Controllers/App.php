<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    /**
     * Site Name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name');
    }

    /**
     * Title.
     *
     * @return string
     */
    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'scaffolder');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(__('Search Results for %s', 'scaffolder'), get_search_query());
        }

        if (is_404()) {
            return __('Not Found', 'scaffolder');
        }

        return get_the_title();
    }
}
