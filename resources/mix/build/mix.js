
const config = require('./config');

const path = require('path');
const url = require('url');
const rimraf = require('rimraf');
const mix = require('laravel-mix');

// Nuke public folder
rimraf.sync(config.paths.dist);

// Inform mix of Scaffolder's directory output structure
module.exports = mix
    .setPublicPath(path.relative(config.paths.root, config.paths.dist))
    .setResourceRoot(config.publicPath)
    .webpackConfig({
        module: {
            rules: [
                {
                    enforce: 'pre',
                    test: /\.(js|s?[ca]ss)$/,
                    include: config.paths.assets,
                    loader: 'import-glob',
                },
            ],
        },
        externals: {
            jquery: 'jQuery',
        },
    })
    .autoload({
        jquery: ['$', 'window.jQuery'],
    });

// Uglify + Image optimization
if (config.enabled.optimize) {
    mix.options({
        postCss: [require('cssnano')],
    });
}

// Cache-busting
if (config.enabled.cacheBusting) {
    mix.version();
}

// Remove leading slashes in mix-manifest.json
mix.then(() => {
    const manifest = File.find(`${config.paths.dist}/mix-manifest.json`);
    const json = JSON.parse(manifest.read());

    Object.keys(json).forEach(key => {
        const hashed = json[key];
        delete json[key];
        json[key.replace(/^\/+/g, '')] = hashed.replace(/^\/+/g, '');
    });

    manifest.write(JSON.stringify(json, null, 2));
});