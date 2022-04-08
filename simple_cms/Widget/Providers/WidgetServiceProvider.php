<?php

namespace SimpleCMS\Widget\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;
use SimpleCMS\Widget\Console\WidgetMakeCommand;
use SimpleCMS\Widget\Factories\AsyncWidgetFactory;
use SimpleCMS\Widget\Factories\WidgetFactory;
use SimpleCMS\Widget\Misc\LaravelApplicationWrapper;
use SimpleCMS\Widget\NamespacesRepository;
use SimpleCMS\Widget\WidgetGroupCollection;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Widget', 'Database/Migrations'));

        Blade::directive('widget', function ($expression) {
            return "<?php echo app('simple_cms.widget')->run($expression); ?>";
        });

        Blade::directive('asyncWidget', function ($expression) {
            return "<?php echo app('simple_cms.async-widget')->run($expression); ?>";
        });

        Blade::directive('widgetGroup', function ($expression) {
            return "<?php echo app('simple_cms.widget-group-collection')->group($expression)->display(); ?>";
        });

        $this->app->singleton('simple_cms.widget.make', function ($app) {
            return new WidgetMakeCommand($app['files']);
        });

        $this->commands('simple_cms.widget.make');

        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/default_widget.php');

        if (! $this->app->runningInConsole()) {
            generate_widget_registered();
        }
        $this->app->register(RouteServiceProvider::class);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->app->bind('simple_cms.widget', function () {
            return new WidgetFactory(new LaravelApplicationWrapper());
        });

        $this->app->bind('simple_cms.async-widget', function () {
            return new AsyncWidgetFactory(new LaravelApplicationWrapper());
        });

        $this->app->singleton('simple_cms.widget-group-collection', function () {
            return new WidgetGroupCollection(new LaravelApplicationWrapper());
        });

        $this->app->singleton('simple_cms.widget-namespaces', function () {
            return new NamespacesRepository();
        });

        $this->app->alias('simple_cms.widget', 'SimpleCMS\Widget\Factories\WidgetFactory');
        $this->app->alias('simple_cms.async-widget', 'SimpleCMS\Widget\Factories\AsyncWidgetFactory');
        $this->app->alias('simple_cms.widget-group-collection', 'SimpleCMS\Widget\WidgetGroupCollection');

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Widget', \SimpleCMS\Widget\Facades\WidgetFacade::class);
        $loader->alias('AsyncWidget', \SimpleCMS\Widget\Facades\AsyncFacade::class);
        $loader->alias('WidgetGroup', \SimpleCMS\Widget\Facades\WidgetGroupFacade::class);

        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/helper.php');
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
                    module_path('Widget', 'Config/'.$file_config) => config_path('widget.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('Widget', 'Config/'.$file_config), ($config=='config' ? 'widget' : $config)
            );
        }
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/simple_cms/widget');

        $sourcePath = module_path('Widget', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/widget';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'widget');

        $sourcePathWidget = base_path('Widgets');
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/widgets';
        }, $this->app['config']->get('view.paths')), [$sourcePathWidget]), 'simple_cms.widget');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/widget');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'widget');
        } else {
            $this->loadTranslationsFrom(module_path('Widget', 'Resources/lang'), 'widget');
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
            app(Factory::class)->load(module_path('Widget', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['simple_cms.widget', 'simple_cms.async-widget'];
    }
}
