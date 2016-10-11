<?php

// Block direct access
if (! defined('ABSPATH')) {
    exit;
}

class Scaffolder
{
    /**
     * Include view file.
     *
     * @param string $view
     * @param array  $variables
     */
    public static function view($view, $variables = array())
    {
        extract($variables);

        ob_start();

        include get_stylesheet_directory().'/resources/views/'.$view.'.php';

        return ob_get_clean();
    }

    /**
     * Include widget view file.
     *
     * @param string $view
     * @param array  $variables
     */
    public static function widgetView($view, $variables = array())
    {
        return self::view('widgets/'.$view, $variables);
    }
}
