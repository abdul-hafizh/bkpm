<?php

namespace SimpleCMS\Shortcode\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesShortcodeServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['shortcodes']->add('row', \SimpleCMS\Shortcode\Repositories\RowShortcode::class);
        $this->app['shortcodes']->add('div', \SimpleCMS\Shortcode\Repositories\DivShortcode::class);
        $this->app['shortcodes']->add('section', \SimpleCMS\Shortcode\Repositories\SectionShortcode::class);
        $this->app['shortcodes']->add('strong', \SimpleCMS\Shortcode\Repositories\StrongShortcode::class);
        $this->app['shortcodes']->add('h1', \SimpleCMS\Shortcode\Repositories\H1Shortcode::class);
        $this->app['shortcodes']->add('h2', \SimpleCMS\Shortcode\Repositories\H2Shortcode::class);
        $this->app['shortcodes']->add('h3', \SimpleCMS\Shortcode\Repositories\H3Shortcode::class);
        $this->app['shortcodes']->add('h4', \SimpleCMS\Shortcode\Repositories\H4Shortcode::class);
        $this->app['shortcodes']->add('h5', \SimpleCMS\Shortcode\Repositories\H5Shortcode::class);
        $this->app['shortcodes']->add('h6', \SimpleCMS\Shortcode\Repositories\H6Shortcode::class);
        $this->app['shortcodes']->add('ul', \SimpleCMS\Shortcode\Repositories\ULShortcode::class);
        $this->app['shortcodes']->add('li', \SimpleCMS\Shortcode\Repositories\LIShortcode::class);
        $this->app['shortcodes']->add('i', \SimpleCMS\Shortcode\Repositories\IShortcode::class);
        $this->app['shortcodes']->add('a', \SimpleCMS\Shortcode\Repositories\AShortcode::class);
        $this->app['shortcodes']->add('br', \SimpleCMS\Shortcode\Repositories\BRShortcode::class);
        $this->app['shortcodes']->add('text', \SimpleCMS\Shortcode\Repositories\TextShortcode::class);


        $this->app['shortcodes']->add('google_docs_view', \SimpleCMS\Shortcode\Repositories\GoogleDocsViewerShortcode::class);
        $this->app['shortcodes']->add('pdf_view', \SimpleCMS\Shortcode\Repositories\PdfViewerShortcode::class);
        $this->app['shortcodes']->add('leaflet_map_view', \SimpleCMS\Shortcode\Repositories\LeafletMapViewShortcode::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
