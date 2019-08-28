
const mix = require('./resources/mix/build/mix');

mix.js('resources/assets/js/app.js', 'js/app.js')

mix.sass('resources/assets/scss/app.scss', 'css/app.css')

mix.sourceMaps(false);