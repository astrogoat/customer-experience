const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .postCss('resources/css/customer-experience.css', 'css', [require('tailwindcss')('tailwind.config.js')])
    .postCss('resources/css/customer-experience-backend.css', 'css', [require('tailwindcss')('tailwind-backend.config.js')])
    .js('resources/js/customer-experience.js', 'js')
    .version()
    .setPublicPath('public/')
