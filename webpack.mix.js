const mix = require('laravel-mix');

const WebpackShellPlugin = require('webpack-shell-plugin');

// Add shell command plugin configured to create JavaScript language file
mix.webpackConfig({
    plugins: [
        new WebpackShellPlugin({
            onBuildStart: ['php artisan lang:js --quiet'],
            onBuildEnd: []
        })
    ]
});

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
mix.js('resources/js/app.js', 'public/js').sass(
    'resources/sass/app.scss',
    'public/css'
);

mix.copyDirectory(['resources/js/jqueryJs/workspace.js'], 'public/js/all.js');

mix.copy('resources/js/jqueryJs/all.js', 'public/js/all.js');
mix.copy('resources/js/jqueryJs/calendar.js', 'public/js/calendar.js');
mix.copy(
    'resources/js/jqueryJs/detailworkspace.js',
    'public/js/detailworkspace.js'
);
mix.copy('resources/js/jqueryJs/location.js', 'public/js/location.js');
mix.copy('resources/js/jqueryJs/generate.js', 'public/js/generate.js');
mix.copy(
    'resources/js/jqueryJs/edit_location.js',
    'public/js/edit_location.js'
);
mix.copyDirectory('resources/css/custom.css', 'public/css');
mix.js('resources/js/jqueryJs/image_map.js', 'public/js/image_map.js');
mix.scripts('resources/js/jqueryJs/config.js', 'public/js/config.js');
mix.scripts(
    'resources/js/jqueryJs/image_mapping.js',
    'public/js/image_mapping.js'
);
mix.styles('resources/css/image_map.css', 'public/css/image_map.css');

mix.styles('resources/css/datatable.css', 'public/css/datatable.css');
mix.styles('resources/css/role-user.css', 'public/css/role-user.css');

mix.js('resources/js/jqueryJs/permission.js', 'public/js/permission.js');
mix.js('resources/js/jqueryJs/role.js', 'public/js/role.js');
mix.js(
    'resources/js/jqueryJs/permission-role.js',
    'public/js/permission-role.js'
);
mix.js('resources/js/jqueryJs/role-user.js', 'public/js/role-user.js');
mix.js('resources/js/jqueryJs/position.js', 'public/js/position.js');
mix.js('resources/js/jqueryJs/program.js', 'public/js/program.js');
mix.copy('resources/js/jqueryJs/add_location.js', 'public/js/add_location.js');
mix.js(
    'resources/js/jqueryJs/register_work_schedules.js',
    'public/js/register_work_schedules.js'
);
mix.js('resources/js/jqueryJs/design.js', 'public/js/design.js');
mix.js(
    'resources/js/jqueryJs/design_without_diagram.js',
    'public/js/design_without_diagram.js'
);
mix.js('resources/js/jqueryJs/setLang.js', 'public/js/setLang.js');
mix.js('resources/js/jqueryJs/showName.js', 'public/js/showName.js');
mix.js('resources/js/jqueryJs/register_seat.js', 'public/js/register_seat.js');
mix.js('resources/js/jqueryJs/edit_seat.js', 'public/js/edit_seat.js');
mix.copy('resources/js/jqueryJs/active_user.js', 'public/js/active_user.js');
mix.copy('resources/js/jqueryJs/get_batches.js', 'public/js/get_batches.js');
mix.js(
    'resources/js/jqueryJs/edit_workspace.js',
    'public/js/edit_workspace.js'
);
mix.copy('resources/js/jqueryJs/show_modal.js', 'public/js/show_modal.js');
mix.js('resources/js/jqueryJs/showDiagram.js', 'public/js/showDiagram.js');

mix.version();
