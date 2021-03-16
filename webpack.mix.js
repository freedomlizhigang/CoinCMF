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

mix.js('resources/js/app.js', 'public/console/js').vue({ version: 2 })
	.styles([
		'resources/sass/reset.css'
	], 'public/console/css/app.css');

mix.browserSync('www.coincmf.com');

mix.webpackConfig({
	resolve: {
		// 1.不需要node polyfilss
		alias: {
			crypto: false
		},
	},
})