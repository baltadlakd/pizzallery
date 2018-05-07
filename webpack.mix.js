


let mix = require('laravel-mix');
const elixir = require('laravel-elixir');

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


      mix.js([
        'resources/assets/js/app.js',
        'resources/assets/js/bs/bootstrap.min.js',
      ], 'public/js')
      .sass('resources/assets/sass/app.scss', 'public/css');
      mix.combine([
        'resources/asset/css/bs/bootstrap.min.css',
        'resources/assets/css/styles.css',
        'public/css/app.css',
      ], 'public/css/app.css');
