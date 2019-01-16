const mix = require('laravel-mix');

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

let tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/preferences.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        tailwindcss('./tailwind.js'),
    ]);

if(mix.inProduction()) {
    mix.version();
}
