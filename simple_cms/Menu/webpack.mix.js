const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public/simple_cms').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/menus.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/menus.css');

if (mix.inProduction()) {
    mix.version();
}
