const { mix } = require('laravel-mix');

mix.options({
    publicPath: 'public/',
});

mix.js('resources/assets/js/app.js', 'js/');

mix.sass('resources/assets/scss/app.scss', 'css/');