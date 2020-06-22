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

mix.ts("resources/ts/app.ts", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .options({
        hmrOptions: {
            host: "mekoi.dev.local",
            port: 8080
        }
    })
    .alias({
        "@": "/resources/ts",
        "@assets": "/resources/ts/assets",
        "@components": "/resources/ts/components",
        "@store": "/resources/ts/store",
        "@types": "/resources/ts/types",
        "@views": "/resources/ts/views",
        "@styles": "/resources/sass",
        "@classes": "/resources/ts/classes"
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
    mix.options({
        extractVueStyles: true,
    })
    .disableNotifications();
