<?php

namespace SimpleCMS\Theme\Providers;

use App;
use Illuminate\Support\Composer;
use File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;
use Illuminate\Routing\Router;
use SimpleCMS\Theme\Asset;
use SimpleCMS\Theme\Breadcrumb;
use SimpleCMS\Theme\Commands\ThemeDestroyCommand;
use SimpleCMS\Theme\Commands\ThemeGeneratorCommand;
use SimpleCMS\Theme\Commands\ThemePublishCommand;
use SimpleCMS\Theme\Manifest;
use SimpleCMS\Theme\Theme;

class ThemeServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../Config/theme.php';

        // Publish config.
        $this->publishes([$configPath => config_path('theme.php')], 'config');

        // Register blade directives:

        $this->addToBlade(['get', 'Theme::get(%s);']);
        $this->addToBlade(['getIfHas', 'Theme::has(%1$s) ? Theme::get(%1$s) : ""']);

        $this->addToBlade(['partial', 'Theme::partial(%s);']);
        $this->addToBlade(['sections', 'Theme::partial("sections.".%s);']);
        $this->addToBlade(['content', null, 'Theme::content();']);

        $this->addToBlade(['asset', 'Theme::asset()->absUrl(%s);']);

        $this->addToBlade(['protect', 'protectEmail(%s);']);

        $this->addToBlade(['styles', 'Theme::asset()->container(%s)->styles();', 'Theme::asset()->styles();']);
        $this->addToBlade(['scriptsTop', 'Theme::asset()->container(%s)->scriptsTop();', 'Theme::asset()->scriptsTop();']);
        $this->addToBlade(['scripts', 'Theme::asset()->container(%s)->scripts();', 'Theme::asset()->scripts();']);


        $this->registerTranslations();

        $this->registerViews();
        $this->registerFactories();
        $this->registerTheme();
        $this->loadMigrationsFrom(module_path('Theme', 'Database/Migrations'));

        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/helpers.php');

        if(!$this->app->runningInConsole()) {
            /* This register all Provider in theme active */
            CoreSupport::providers_autoload(base_path('Themes/' . themeActive() . '/src/Providers'), 'Themes\\' . themeActive() . '\\src\Providers\\', '');
        }
        if(!$this->app->runningInConsole()) {
            /** This register all Helpers in theme active  */
            CoreSupport::helpers_autoload(base_path('Themes/' . themeActive() . '/helpers'));
            /** This register Helpers */
            $this->app['files']->requireOnce(__DIR__ . '/../Helpers/general-hook-frontend.php');
        }
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
        $this->app['router']->aliasMiddleware('theme', \SimpleCMS\Theme\Http\Middleware\ThemeLoader::class);
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Theme', \SimpleCMS\Theme\Facades\Theme::class);

        $configPath = __DIR__.'/../Config/theme.php';

        // Merge config to allow user overwrite.
        $this->mergeConfigFrom($configPath, 'theme');

        // Register providers:
        $this->registerAsset();
        $this->registerTheme();
        $this->registerWidget();
        $this->registerBreadcrumb();
        $this->registerManifest();

        // Register commands:
        $this->registerThemeGenerator();
        $this->registerWidgetGenerator();
        $this->registerThemeList();
        $this->registerThemeDuplicate();
        $this->registerThemeDestroy();
        $this->registerThemePublish();

        // Assign commands:
        $this->commands(
            'simple_cms.theme.create',
            'simple_cms.theme.widget',
            'simple_cms.theme.list',
            'simple_cms.theme.duplicate',
            'simple_cms.theme.destroy',
            'simple_cms.theme.publish'
        );

    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/simple_cms/theme');

        $sourcePath = module_path('Theme', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/theme';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'theme');

        /* theme view global */
        $sourcePathThemes = base_path('Themes');
        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path;
        }, $this->app['config']->get('view.paths')), [$sourcePathThemes]), 'themes');

        /* theme active */
        $themeActive = simple_cms_setting('theme_active');
        $theme = \Theme::uses($themeActive);
        $sourcePathThemesActive = $theme->getThemePath();
        $this->loadViewsFrom(array_merge(array_map(function ($path) use($themeActive) {
            return $path . '/themes/'. $themeActive;
        }, $this->app['config']->get('view.paths')), [$sourcePathThemesActive]), 'theme_active');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/theme');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'theme');
        } else {
            $this->loadTranslationsFrom(module_path('Theme', 'Resources/lang'), 'theme');
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
            app(Factory::class)->load(module_path('Theme', 'Database/factories'));
        }
    }

    /**
     * Set a blade directive
     *
     * @return void
     */
    protected function addToBlade($array){
        Blade::directive($array[0], function ($data) use ($array) {
            if(!$data) return '<?php echo '.$array[2].' ?>';

            return sprintf('<?php echo '.$array[1].' ?>',
                null !== $data ? $data : "get_defined_vars()['__data']"
            );
        });
    }


    /**
     * Register asset provider.
     *
     * @return void
     */
    public function registerAsset()
    {
        $this->app->singleton('asset', function($app)
        {
            return new Asset();
        });
    }

    /**
     * Register theme provider.
     *
     * @return void
     */
    public function registerTheme()
    {
        $this->app->singleton('theme', function($app)
        {
            return new Theme($app['config'], $app['events'], $app['view'], $app['asset'], $app['files'], $app['breadcrumb'], $app['manifest']);
        });

        $this->app->alias('theme', 'SimpleCMS\Theme\Contracts\Theme');
    }

    /**
     * Register widget provider.
     *
     * @return void
     */
    public function registerWidget()
    {
        /*$this->app->singleton('widget', function($app)
        {
            return new Widget($app['view']);
        });*/
    }

    /**
     * Register breadcrumb provider.
     *
     * @return void
     */
    public function registerBreadcrumb()
    {
        $this->app->singleton('breadcrumb', function($app)
        {
            return new Breadcrumb($app['files']);
        });
    }

    /**
     * Register manifest provider.
     *
     * @return void
     */
    public function registerManifest()
    {
        $this->app->singleton('manifest', function($app)
        {
            return new Manifest($app['files']);
        });
    }

    /**
     * Register generator of theme.
     *
     * @return void
     */
    public function registerThemeGenerator()
    {
        $this->app->singleton('simple_cms.theme.create', function($app)
        {
            return new \SimpleCMS\Theme\Commands\ThemeGeneratorCommand($app['config'], $app['files'], $app['composer']);
        });
    }

    /**
     * Register duplicate of theme.
     *
     * @return void
     */
    public function registerThemeDuplicate()
    {
        $this->app->singleton('simple_cms.theme.duplicate', function($app)
        {
            return new \SimpleCMS\Theme\Commands\ThemeDuplicateCommand($app['config'], $app['files']);
        });
    }

    /**
     * Register generator of widget.
     *
     * @return void
     */
    public function registerWidgetGenerator()
    {
        $this->app->singleton('simple_cms.theme.widget', function($app)
        {
            return new \SimpleCMS\Theme\Commands\WidgetGeneratorCommand($app['config'], $app['files']);
        });
    }

    /**
     * Register theme destroy.
     *
     * @return void
     */
    public function registerThemeDestroy()
    {
        $this->app->singleton('simple_cms.theme.destroy', function($app)
        {
            return new \SimpleCMS\Theme\Commands\ThemeDestroyCommand($app['config'], $app['files']);
        });
    }

    /**
     * Register list themes.
     *
     * @return void
     */
    public function registerThemeList()
    {
        $this->app->singleton('simple_cms.theme.list', function($app)
        {
            return new \SimpleCMS\Theme\Commands\ThemeListCommand($app['config'], $app['files']);
        });
    }

    /**
     * Register publish themes.
     *
     * @return void
     */
    public function registerThemePublish()
    {
        $this->app->singleton('simple_cms.theme.publish', function($app)
        {
            return new \SimpleCMS\Theme\Commands\ThemePublishCommand($app['config'], $app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('asset', 'theme', 'widget', 'breadcrumb');
    }
}
