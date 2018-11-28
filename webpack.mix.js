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
mix.scripts('resources/js/image_map.js', 'public/js/image_map.js');
mix.scripts('resources/js/config.js', 'public/js/config.js');
mix.scripts('resources/js/image_mapping.js', 'public/js/image_mapping.js');
mix.styles('resources/css/image_map.css', 'public/css/image_map.css');

mix.styles('resources/css/datatable.css', 'public/css/datatable.css');
mix.styles('resources/css/role-user.css', 'public/css/role-user.css');

mix.js('resources/js/permission.js', 'public/js/permission.js');
mix.js('resources/js/role.js', 'public/js/role.js');
mix.js('resources/js/permission-role.js', 'public/js/permission-role.js');
mix.js('resources/js/role-user.js', 'public/js/role-user.js');
mix.js('resources/js/position.js', 'public/js/position.js');
mix.js('resources/js/program.js', 'public/js/program.js');
mix.copyDirectory('resources/js/add_location.js', 'public/js');

mix.version();
