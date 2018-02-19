const { mix } = require('laravel-mix');

mix

.options({
    publicPath: 'public/'
})

.js('resources/assets/js/app.js', 'js/')

.sass('resources/assets/scss/app.scss', 'css/');