const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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
// elixir.config.sourcemaps = false;

elixir(mix => {
    mix.sass('app.scss')
        .styles([
            'sb-admin-2.css',
            'metisMenu.css'
        ])
        .webpack('app.js');
});

elixir(function(mix) {
    mix.version(['css/app.css', 'js/app.js']);
});

// var elixir = require('laravel-elixir');
//
// elixir(function (mix){
//     mix.browserify('app.js');
// })
