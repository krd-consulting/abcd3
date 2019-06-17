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

const tailwindcss = require('tailwindcss');

mix.webpackConfig({
   resolve: {
       alias: {
           "@": path.resolve(
               __dirname,
               "resources/js"
           )
       }
   }
});

mix.js('resources/js/App', 'public/js/app.js')
    .js('resources/js/Preferences', 'public/js/preferences.js')
    .js('resources/js/FormBuilder', 'public/js/formbuider.js')
    .postCss('resources/css/app.css', 'public/css', [
        tailwindcss,
    ]);

if(mix.inProduction()) {
    mix.version();
}
