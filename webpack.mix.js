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

mix.scripts('resources/js/scripts.js', 'public/js/scripts.js')
    .scripts('resources/js/panel/scripts.js', 'public/admin-panel/js/scripts.js')
    .scripts('resources/js/panel/functions.js', 'public/admin-panel/js/functions.js')
    .scripts('resources/js/panel/theme.js', 'public/admin-panel/js/theme.js')
    .scripts('resources/js/panel/login/scripts.js', 'public/admin-panel/login/js/scripts.js')
    .scripts('resources/js/panel/login/functions.js', 'public/admin-panel/login/js/functions.js')
    .scripts('resources/js/panel/users/user_add.js', 'public/admin-panel/users/js/user_add.js')
    .scripts('resources/js/panel/users/user_index.js', 'public/admin-panel/users/js/user_index.js')
    .scripts('resources/js/panel/content/content_add.js', 'public/admin-panel/content/js/content_add.js')
    .scripts('resources/js/panel/content/content_index.js', 'public/admin-panel/content/js/content_index.js')
    .scripts('resources/js/header.js', 'public/js/header.js')
    .scripts('resources/js/footer.js', 'public/js/footer.js')
    .scripts('resources/js/functions.js', 'public/js/functions.js')

    // Widgets
    .scripts(
        [
            'resources/js/widgets/table-weather-summary.js'
        ],
        'public/js/widgets.js'
    )

    .js('resources/js/vue.js', 'public/js')
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/assets/js/jquery.js')
    .copy('node_modules/jquery.easing/jquery.easing.min.js', 'public/assets/js/jquery.easing.js')

    .scripts([
        'node_modules/bootstrap-select/dist/js/bootstrap-select.js',
        'node_modules/bootstrap-select/dist/i18n/defaults-es_ES.js',
    ], 'public/assets/js/bootstrap-select.js')
    .styles('node_modules/bootstrap-select/dist/css/bootstrap-select.css', 'public/assets/css/bootstrap-select.css')

    //.js('resources/js/app.js', 'public/js/app.js')
    .scripts('node_modules/bootstrap/dist/js/bootstrap.js', 'public/assets/js/bootstrap.js')

    .js('resources/js/assets/popper.js', 'public/assets/js')
    /*
     .scripts([
     'node_modules/popper.js/dist/esr/popper-utils.js',
     'node_modules/popper.js/dist/esr/popper.js',
     ], 'public/assets/js/popper.js')
     */

    //.js('resources/js/assets/datatables.js', 'public/assets/js')
    .scripts([
        'node_modules/datatables.net/js/jquery.dataTables.js',
        'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
        'node_modules/datatables.net-autofill/js/dataTables.autoFill.js',
        'node_modules/datatables.net-autofill-bs4/js/autoFill.bootstrap4.js',
        'node_modules/datatables.net-buttons/js/dataTables.buttons.js',
        'node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js',
        'node_modules/datatables.net-colreorder/js/dataTables.colReorder.js',
        'node_modules/datatables.net-colreorder-bs4/js/colReorder.bootstrap4.js',
        'node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.js',
        'node_modules/datatables.net-fixedcolumns-bs4/js/fixedColumns.bootstrap4.js',
        'node_modules/datatables.net-fixedheaders/js/dataTables.fixedHeaders.js',
        'node_modules/datatables.net-fixedheaders-bs4/js/fixedHeaders.bootstrap4.js',
        'node_modules/datatables.net-keytable/js/dataTables.keyTable.js',
        'node_modules/datatables.net-keytable-bs4/js/keyTable.bootstrap4.js',
        'node_modules/datatables.net-responsive/js/dataTables.responsive.js',
        'node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.js',
        'node_modules/datatables.net-rowgroup/js/dataTables.rowGroup.js',
        'node_modules/datatables.net-rowgroup-bs4/js/rowGroup.bootstrap4.js',
        'node_modules/datatables.net-rowreorder/js/dataTables.rowReorder.js',
        'node_modules/datatables.net-rowreorder-bs4/js/rowReorder.bootstrap4.js',
        'node_modules/datatables.net-scroller/js/dataTables.scroller.js',
        'node_modules/datatables.net-scroller-bs4/js/scroller.bootstrap4.js',
        'node_modules/datatables.net-select/js/dataTables.select.js',
        'node_modules/datatables.net-select-bs4/js/select.bootstrap4.js',
        //'node_modules/datatables.net-translations/js/spanish.js',
    ], 'public/assets/js/datatables.js')

    .js('resources/js/assets/chart.js', 'public/assets/js')
    .js('resources/js/assets/fontawesome.js', 'public/assets/js')

    .scripts('resources/js/panel/demos/chart-area-demo.js', 'public/admin-panel/js/demos/chart-area-demo.js')
    .scripts('resources/js/panel/demos/chart-bar-demo.js', 'public/admin-panel/js/demos/chart-bar-demo.js')
    .scripts('resources/js/panel/demos/chart-pie-demo.js', 'public/admin-panel/js/demos/chart-pie-demo.js')
    .scripts('resources/js/panel/demos/datatables-demo.js', 'public/admin-panel/js/demos/datatables-demo.js')

    .sass('resources/sass/styles.scss', 'public/css/')
    .sass('resources/sass/widgets.scss', 'public/css/')
    .sass('resources/sass/panel/styles.scss', 'public/admin-panel/css')
    .sass('resources/sass/panel/login/styles.scss', 'public/admin-panel/login/css')
    .sass('resources/sass/assets/bootstrap.scss', 'public/assets/css')
    .sass('resources/sass/assets/fontawesome.scss', 'public/assets/css')
    .sass('resources/sass/assets/datatables.scss', 'public/assets/css')
    .sass('node_modules/weather-icons2/sass/weather-icons.scss', 'public/assets/css')

    .autoload({
        jquery:['$', 'window.jQuery', 'jQuery', 'window.$', 'jquery', 'window.jquery'],
        Popper:['popper', 'Popper', 'popper.js']
    });

mix.browserSync({
    proxy:'localhost:8000'
});
