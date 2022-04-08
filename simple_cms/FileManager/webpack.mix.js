const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public/simple_cms').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/filemanager.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/filemanager.css');

if (mix.inProduction()) {
    mix.version();
}
