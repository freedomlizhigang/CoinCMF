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

mix.js('resources/js/app.js', 'public/console/js')
	.styles([
		'resources/sass/reset.css'
	], 'public/console/css/app.css');

const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
				files: [
					'app/**/*',
					'public/**/*',
					'resources/views/**/*',
					'routes/**/*'
				]
        })
    ]
});