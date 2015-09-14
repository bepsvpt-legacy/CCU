var elixir = require('laravel-elixir');
require('dotenv').load();

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

var cssPath = ('production' === process.env.APP_ENV) ? '../cdn/css/ccu.min.css' : 'resources/views/css/ccu.css.php';

elixir(function(mix) {
    mix.sass([
            'ccu.scss'
        ], cssPath);
});