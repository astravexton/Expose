var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
  mix.styles([
    './resources/css/bootstrap.min.css'
  ], './public/css/app.min.css', '.');

  mix.scripts([
    './resources/js/jquery-1.11.3.min.js',
    './resources/js/bootstrap.min.js',
    './resources/js/bootbox.min.js',
    './resources/js/app.js'
  ], './public/js/app.min.js', '.');

  mix.version([
    './public/css/app.min.css',
    './public/js/app.min.js'
  ]);
});
