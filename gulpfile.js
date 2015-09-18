var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass([
            'ccu.scss'
        ], 'resources/views/css/ccu.css.php')
        .scripts([
            '../../views/js/angular.js.php',
            '../../views/js/routes.js.php',
            '../../views/js/controllers/*.js',
            '../../views/js/directives/*.js',
            '../../views/js/factories/*.js'
        ], 'resources/views/js/all.js.php');
});