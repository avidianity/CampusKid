const mix = require("laravel-mix");
require("laravel-mix-alias");
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.ts("resources/js/app.ts", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .options({
        hmrOptions: {
            host: "mekoi.dev.local",
            port: 8080
        }
    })
    .alias({
        "@": "/resources/js",
        "@assets": "/resources/js/assets",
        "@components": "/resources/js/components",
        "@store": "/resources/js/store",
        "@types": "/resources/js/types",
        "@views": "/resources/js/views",
        "@styles": "/resources/sass"
    })
    .webpackConfig({
        devServer: {
            compress: true,
            historyApiFallback: true,
            host: "mekoi.dev.local",
            proxy: {
                "**": {
                    target: "http://mekoi.dev.local/campuskid/public"
                }
            }
        }
    })
    .disableNotifications();
