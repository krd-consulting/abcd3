const mix = require("laravel-mix");

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

mix.webpackConfig({
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js")
        }
    }
});

mix.postCss("resources/css/app.css", "public/css", [require("tailwindcss")]).js(
    "resources/js/App",
    "public/js/app.js"
);

mix.browserSync("127.0.0.1:8000");

if (mix.inProduction()) {
    mix.version();
}
