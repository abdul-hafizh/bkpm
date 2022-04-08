const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public/simple_cms').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/liveeditor.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/liveeditor.css');

if (mix.inProduction()) {
    mix.version();
}
