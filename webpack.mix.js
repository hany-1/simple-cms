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

mix.copy('node_modules/froala-editor/css', 'public/froala/css');
mix.copy('node_modules/froala-editor/js', 'public/froala/js');
mix.js(['resources/js/app.js', 'resources/js/web.js'], 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
