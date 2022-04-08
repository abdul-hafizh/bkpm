<?php

namespace SimpleCMS\Translation\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\AliasLoader;
use SimpleCMS\Core\Supports\CoreSupport;
use Illuminate\Translation\FileLoader as LaravelFileLoader;
use Illuminate\Translation\TranslationServiceProvider as LaravelTranslationServiceProvider;
use SimpleCMS\Translation\Cache\RepositoryFactory as CacheRepositoryFactory;
use SimpleCMS\Translation\Commands\CacheFlushCommand;
use SimpleCMS\Translation\Commands\FileLoaderCommand;
use SimpleCMS\Translation\Loaders\CacheLoader;
use SimpleCMS\Translation\Loaders\DatabaseLoader;
use SimpleCMS\Translation\Loaders\FileLoader;
use SimpleCMS\Translation\Loaders\MixedLoader;
use SimpleCMS\Translation\Http\Middleware\TranslationMiddleware;
use SimpleCMS\Translation\Models\Translation;
use SimpleCMS\Translation\Repositories\LanguageRepository;
use SimpleCMS\Translation\Repositories\TranslationRepository;
use SimpleCMS\Translation\Routes\ResourceRegistrar;
use SimpleCMS\Translation\UriLocalizer;

class TranslationServiceProvider extends LaravelTranslationServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  **/
        CoreSupport::helpers_autoload(module_path('Translation','Helpers'));

        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Translation', 'Database/Migrations'));

//        if(!$this->app->runningInConsole()) {
            $this->app->register(RouteServiceProvider::class);
//        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'translator');
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'translation');
        parent::register();

        /*$kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);*/
        /*$kernel->pushMiddleware(\SimpleCMS\Translation\Http\Middleware\CookieMiddleware::class);*/
//        if (!$this->app->runningInConsole()) {
//            $kernel->pushMiddleware(\SimpleCMS\Translation\Http\Middleware\TranslationMiddleware::class);
//        }
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('UriLocalizer', \SimpleCMS\Translation\Facades\UriLocalizer::class);

        $this->registerCacheRepository();
        $this->registerFileLoader();
        $this->registerCacheFlusher();

        $this->app->singleton('translation.uri.localizer', UriLocalizer::class);
        $this->app[\Illuminate\Routing\Router::class]->aliasMiddleware('localize', TranslationMiddleware::class);

        // Fix issue with laravel prepending the locale to localize resource routes:
        $this->app->bind('Illuminate\Routing\ResourceRegistrar', ResourceRegistrar::class);

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
                    module_path('Translation', 'Config/'.$file_config) => config_path('translator.php'),
                ], 'config');
            }
            if ($config != 'config') {
                $this->mergeConfigFrom(
                    module_path('Translation', 'Config/' . $file_config), $config
                );
            }
        }
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/simple_cms/translation');

        $sourcePath = module_path('Translation', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/translation';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'translation');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/translation');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'translation');
        } else {
            $this->loadTranslationsFrom(module_path('Translation', 'Resources/lang'), 'translation');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Translation', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(parent::provides(), ['translation.cache.repository', 'translation.uri.localizer', 'translation.loader']);
    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $app = $this->app;
        $this->app->singleton('translation.loader', function ($app) {
            $defaultLocale = simple_cms_setting('locale');
            $loader        = null;
            $source        = $app['config']->get('translator.source');

            switch ($source) {
                case 'mixed':
                    $laravelFileLoader = new LaravelFileLoader($app['files'], $app->basePath() . '/resources/lang');
                    $fileLoader        = new FileLoader($defaultLocale, $laravelFileLoader);
                    $databaseLoader    = new DatabaseLoader($defaultLocale, $app->make(TranslationRepository::class));
                    $loader            = new MixedLoader($defaultLocale, $fileLoader, $databaseLoader);
                    break;
                case 'mixed_db':
                    $laravelFileLoader = new LaravelFileLoader($app['files'], $app->basePath() . '/resources/lang');
                    $fileLoader        = new FileLoader($defaultLocale, $laravelFileLoader);
                    $databaseLoader    = new DatabaseLoader($defaultLocale, $app->make(TranslationRepository::class));
                    $loader            = new MixedLoader($defaultLocale, $databaseLoader, $fileLoader);
                    break;
                case 'database':
                    $loader = new DatabaseLoader($defaultLocale, $app->make(TranslationRepository::class));
                    break;
                default:case 'files':
                $laravelFileLoader = new LaravelFileLoader($app['files'], $app->basePath() . '/resources/lang');
                $loader            = new FileLoader($defaultLocale, $laravelFileLoader);
                break;
            }
            if ($app['config']->get('translator.cache.enabled')) {
                $loader = new CacheLoader($defaultLocale, $app['translation.cache.repository'], $loader, $app['config']->get('translator.cache.timeout'));
            }
            return $loader;
        });
    }

    /**
     *  Register the translation cache repository
     *
     *  @return void
     */
    public function registerCacheRepository()
    {
        $this->app->singleton('translation.cache.repository', function ($app) {
            $cacheStore = $app['cache']->getStore();
            return CacheRepositoryFactory::make($cacheStore, $app['config']->get('translator.cache.suffix'));
        });
    }

    /**
     * Register the translator:load language file loader.
     *
     * @return void
     */
    protected function registerFileLoader()
    {
        $app                   = $this->app;
        $defaultLocale         = simple_cms_setting('locale', $app['config']->get('app.locale'));
        $languageRepository    = $app->make(LanguageRepository::class);
        $translationRepository = $app->make(TranslationRepository::class);
        $translationsPath      = $app->basePath() . '/resources/lang';
        $command               = new FileLoaderCommand($languageRepository, $translationRepository, $app['files'], $translationsPath, $defaultLocale);

        $this->app['command.simple_cms:translator:load'] = $command;
        $this->commands('command.simple_cms:translator:load');
    }

    /**
     *  Flushes the translation cache
     *
     *  @return void
     */
    public function registerCacheFlusher()
    {
        //$cacheStore      = $this->app['cache']->getStore();
        //$cacheRepository = CacheRepositoryFactory::make($cacheStore, $this->app['config']->get('translator.cache.suffix'));
        $command = new CacheFlushCommand($this->app['translation.cache.repository'], $this->app['config']->get('translator.cache.enabled'));

        $this->app['command.simple_cms:translator:flush'] = $command;
        $this->commands('command.simple_cms:translator:flush');
    }
}
