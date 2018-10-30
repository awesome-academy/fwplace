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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.js(
    ['resources/js/workspace.js'],
    'public/js/all.js'
);

mix.copyDirectory('resources/js/all.js', 'public/js');
mix.copyDirectory('resources/js/calendar.js', 'public/js');
mix.copyDirectory('resources/js/detailworkspace.js', 'public/js');
mix.copyDirectory('resources/js/generate.js', 'public/js');
mix.copyDirectory('resources/js/jquery-ui.js', 'public/js');
mix.copyDirectory('resources/js/location.js', 'public/js');
mix.copyDirectory('resources/js/usertimesheet .js', 'public/js');
mix.copyDirectory('resources/js/webfont .js', 'public/js');
