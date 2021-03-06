<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Template\Blade;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\BladeProvider;

/*
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('scaffolder/app.css', asset_path('css/app.css'), false, null);
    wp_enqueue_script('scaffolder/app.js', asset_path('js/app.js'), ['jquery'], null, true);
}, 100);

/*
 * Theme support
 */
add_action('after_setup_theme', function () {
    /*
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /*
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /*
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /*
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /*
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /*
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/*
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /*
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'menu-primary'   => __('Primary menu', 'scaffolder'),
        'menu-secondary' => __('Secondary menu', 'scaffolder'),
        'menu-footer'    => __('Footer menu', 'scaffolder'),
    ]);

/*
 * Add image sizes.
 * @link https://developer.wordpress.org/reference/functions/add_image_size/
 */
    // add_image_size('custom-size', 220, 180);
}, 20);

/*
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ];

    register_sidebar([
        'name'          => __('Primary', 'scaffolder'),
        'id'            => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name'          => __('Footer', 'scaffolder'),
        'id'            => 'sidebar-footer',
    ] + $config);
});

/*
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    scaffolder('blade')->share('post', $post);
});

/*
 * Setup Scaffolder options
 */
add_action('after_setup_theme', function () {
    /*
     * Add JsonManifest to Scaffolder container
     */
    scaffolder()->singleton('scaffolder.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /*
     * Add Blade to Scaffolder container
     */
    scaffolder()->singleton('scaffolder.blade', function (Container $app) {
        $cachePath = config('view.compiled');

        if (! file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }

        (new BladeProvider($app))->register();

        return new Blade($app['view']);
    });

    /*
     * Create @asset() Blade directive
     */
    scaffolder('blade')->compiler()->directive('asset', function ($asset) {
        return '<?= '.__NAMESPACE__."\\asset_path({$asset}); ?>";
    });
});
