<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the scaffolder container.
 *
 * @param  string          $abstract
 * @param  array           $parameters
 * @param  Container       $container
 * @return Container|mixed
 */
function scaffolder($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();

    if (! $abstract) {
        return $container;
    }

    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("scaffolder.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string             $key
 * @param  mixed                    $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return scaffolder('config');
    }

    if (is_array($key)) {
        return scaffolder('config')->set($key);
    }

    return scaffolder('config')->get($key, $default);
}

/**
 * @param  string $file
 * @param  array  $data
 * @return string
 */
function template($file, $data = [])
{
    if (remove_action('wp_head', 'wp_enqueue_scripts', 1)) {
        wp_enqueue_scripts();
    }

    return scaffolder('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view.
 * @param $file
 * @param  array  $data
 * @return string
 */
function template_path($file, $data = [])
{
    return scaffolder('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return scaffolder('assets')->getUri($asset);
}

/**
 * @param  string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('scaffolder/filter_templates/paths', [
        'views',
        'resources/views',
    ]);

    $paths_pattern = '#^('.implode('|', $paths).')/#';

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            // Remove .blade.php/.blade/.php from template names
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            // Remove partial $paths from the beginning of template names
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                        "{$template}.blade.php",
                        "{$template}.php",
                    ];
                });
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param  string|string[] $templates Relative path to possible template files
 * @return string          Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar.
 * @return bool
 */
function display_sidebar()
{
    static $display;

    isset($display) || $display = apply_filters('scaffolder/display_sidebar', false);

    return $display;
}
