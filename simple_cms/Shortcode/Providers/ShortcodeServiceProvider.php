<?php

namespace SimpleCMS\Shortcode\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;
use SimpleCMS\Shortcode\Commands\MakeShortcodeCommand;
use SimpleCMS\Shortcode\Debugbar\ShortcodeCollector;
use SimpleCMS\Shortcode\Facades\Shortcodes;
use SimpleCMS\Shortcode\Manager;

class ShortcodeServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  */
        CoreSupport::helpers_autoload(module_path('Shortcode','Helpers'));

        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Shortcode', 'Database/Migrations'));

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            // Registering package commands.
            $this->commands([
                MakeShortcodeCommand::class,
            ]);
        }

        if ($this->app['config']->get('shortcode.debugbar') && $this->app->bound('debugbar')) {
            $this->app['debugbar']->addCollector(new ShortcodeCollector());
        }

        Blade::directive('shortcodes', function ($expression) {
            if ($expression === '') {
                return '<?php ob_start() ?>';
            } else {
                return "<?php echo app('shortcodes')->render($expression); ?>";
            }
        });

        Blade::directive('endshortcodes', function () {
            return "<?php echo app('shortcodes')->render(ob_get_clean()); ?>";
        });

//        if (!$this->app->runningInConsole()) {
            $this->app->register(RouteServiceProvider::class);
            $this->app->register(RepositoriesShortcodeServiceProvider::class);
//        }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerView();
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Shortcodes', Shortcodes::class);

        // Register the service the package provides.
        $this->app->singleton('shortcodes', function ($app) {
            return new Manager($app, $app->make('config')->get('shortcode'));
        });
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
                    module_path('Shortcode', 'Config/'.$file_config) => config_path('shortcode.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('Shortcode', 'Config/'.$file_config), ($config=='config' ? 'shortcode' : $config)
            );
        }
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerView()
    {
        $this->app->singleton('view', function ($app) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];

            $finder = $app['view.finder'];

            $factory = new \SimpleCMS\Shortcode\View\Factory($resolver, $finder, $app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $factory->setContainer($app);

            $factory->share('app', $app);

            return $factory;
        });
    }
    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/simple_cms/shortcode');

        $sourcePath = module_path('Shortcode', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/shortcode';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'shortcode');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/shortcode');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'shortcode');
        } else {
            $this->loadTranslationsFrom(module_path('Shortcode', 'Resources/lang'), 'shortcode');
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
            app(Factory::class)->load(module_path('Shortcode', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['shortcodes', 'view'];
    }
}
