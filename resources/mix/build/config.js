
const path = require("path");
const { argv } = require("yargs");
const merge = require("webpack-merge");

const desire = require("./util/desire");

const userConfig = merge(
    desire(`${__dirname}/../config`),
    desire(`${__dirname}/../config-local`)
);

const isProduction = !!((argv.env && argv.env.production) || argv.p);
const rootPath = userConfig.paths && userConfig.paths.root
    ? userConfig.paths.root
    : process.cwd();

const config = merge({
    open: true,
    proxyUrl: "http://localhost:3000",
    paths: {
        root: rootPath,
        assets: path.join(rootPath, "resources/assets"),
        dist: path.join(rootPath, "public"),
    },
    enabled: {
        optimize: isProduction,
        cacheBusting: isProduction,
        watcher: !!argv.watch,
    },
    html: ["app/**/*.php", "config/**/*.php", "resources/views/**/*.php"].map(
        pattern => `${rootPath}/${pattern}`
    ),
}, userConfig);

module.exports = merge(config, {
    env: Object.assign(
        { production: isProduction, development: !isProduction },
        argv.env
    ),
    publicPath: `${config.publicPath}/${path.basename(config.paths.dist)}/`,
    manifest: {},
});

if (process.env.DEVURL) {
    module.exports.devUrl = process.env.DEVURL;
}

/**
 * Set the commonly-used NODE_ENV environment variable
 */
if (process.env.NODE_ENV === undefined) {
    process.env.NODE_ENV = isProduction ? "production" : "development";
}

/**
 * If your publicPath differs between environments, but you know it at compile time,
 * then set SCAFFOLDER_DIST_PATH as an environment variable before compiling.
 * Example:
 *   SCAFFOLDER_DIST_PATH=/wp-content/themes/sage/dist yarn build:production
 */
if (process.env.SCAFFOLDER_DIST_PATH) {
    module.exports.publicPath = process.env.SCAFFOLDER_DIST_PATH;
}