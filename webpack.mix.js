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

mix.copyDirectory(
    ['resources/js/workspace.js'],
    'public/js/all.js'
);

mix.copyDirectory('resources/js/all.js', 'public/js');
mix.copyDirectory('resources/js/calendar.js', 'public/js');
mix.copyDirectory('resources/js/detailworkspace.js', 'public/js');
mix.copyDirectory('resources/js/generate.js', 'public/js');
mix.copyDirectory('resources/js/location.js', 'public/js');
mix.copyDirectory('resources/css/custom.css', 'public/css');

mix.styles('resources/css/datatable.css', 'public/css/datatable.css');

mix.js('resources/js/role.js', 'public/js/role.js');

mix.version();
