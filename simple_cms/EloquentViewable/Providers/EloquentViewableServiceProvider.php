<?php

namespace SimpleCMS\EloquentViewable\Providers;

use Illuminate\Support\ServiceProvider;
use SimpleCMS\Core\Supports\CoreSupport;
use SimpleCMS\EloquentViewable\Contracts\CrawlerDetector as CrawlerDetectorContract;
use SimpleCMS\EloquentViewable\Contracts\View as ViewContract;
use SimpleCMS\EloquentViewable\Contracts\Views as ViewsContract;
use SimpleCMS\EloquentViewable\Contracts\Visitor as VisitorContract;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Container\Container;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use SimpleCMS\EloquentViewable\CrawlerDetectAdapter;
use SimpleCMS\EloquentViewable\View;
use SimpleCMS\EloquentViewable\Views;
use SimpleCMS\EloquentViewable\Visitor;

class EloquentViewableServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  */
        CoreSupport::helpers_autoload(module_path('EloquentViewable','Helpers'));
        $this->loadMigrationsFrom(module_path('EloquentViewable', 'Database/Migrations'));

        /* set dynamic config ignored_ip_addresses*/
        $setting_ignored_ip_addresses = simple_cms_setting('eloquentviewable_ignored_ip_addresses', '127.0.0.1');
        $setting_ignored_ip_addresses = explode(',', $setting_ignored_ip_addresses);
        $this->app['config']->set('eloquentviewable.ignored_ip_addresses', $setting_ignored_ip_addresses);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->app->when(Views::class)
            ->needs(CacheRepository::class)
            ->give(function (): CacheRepository {
                return $this->app['cache']->store(
                    $this->app['config']['eloquentviewable']['cache']['store']
                );
            });

        $this->app->bind(ViewsContract::class, Views::class);

        $this->app->bind(ViewContract::class, View::class);

        $this->app->bind(VisitorContract::class, Visitor::class);

        $this->app->bind(CrawlerDetectAdapter::class, function ($app) {
            $detector = new CrawlerDetect(
                $app['request']->headers->all(),
                $app['request']->server('HTTP_USER_AGENT')
            );

            return new CrawlerDetectAdapter($detector);
        });

        $this->app->singleton(CrawlerDetectorContract::class, CrawlerDetectAdapter::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $configs = $this->app['files']->glob(__DIR__.'/../Config/*.php');
        foreach ($configs as $config) {
            $config = str_replace('.php','',$config);
            $config = explode('/',$config);
            $config = end($config);
            $file_config = $config.'.php';
            if($config=='config'){
                $this->publishes([
                    module_path('EloquentViewable', 'Config/'.$file_config) => config_path('eloquentviewable.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('EloquentViewable', 'Config/'.$file_config), ($config=='config' ? 'eloquentviewable' : $config)
            );
        }
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
