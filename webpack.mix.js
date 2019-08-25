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
  //.js('resources/js/assets/jquery.js', 'public/assets/js')
  //.js('resources/js/assets/jquery.easing.js', 'public/assets/js')
  .copy('node_modules/jquery/dist/jquery.min.js', 'public/assets/js/jquery.js')
  .copy('node_modules/jquery.easing/jquery.easing.min.js', 'public/assets/js/jquery.easing.js')
  .js('resources/js/assets/bootstrap.js', 'public/assets/js')
  .js('resources/js/assets/popper.js', 'public/assets/js')
  .js('resources/js/assets/datatables.js', 'public/assets/js')
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
    jquery: ['$', 'window.jQuery',"jQuery","window.$","jquery","window.jquery"],
    Popper: ['popper', 'Popper', 'popper.js'],
    DataTable : ['datatables.net-bs4', 'Datatable']
  });

