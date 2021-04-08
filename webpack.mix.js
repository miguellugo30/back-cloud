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

mix.js([
        'resources/js/empresas.js',
        'resources/js/usuarios.js',
        'resources/js/acciones_empresa.js',
        'resources/js/conexiones.js',
        'resources/js/catNas.js',
        'resources/js/logactividades.js'
    ], 'public/js/app.js');
/*
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
*/
