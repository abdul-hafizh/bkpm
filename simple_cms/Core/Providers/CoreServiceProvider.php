<?php

namespace SimpleCMS\Core\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Core;
use SimpleCMS\Core\Exceptions\Handler;
use SimpleCMS\Core\Models\SettingModel;
use SimpleCMS\Core\Supports\CoreAsset;
use SimpleCMS\Core\Supports\CoreSupport;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        \Illuminate\Support\Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }
                return $value;
            });
        });

        /** This register all Helpers if have  */
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/FormSettingGeneral.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/FormSettingHomepage.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/FormSettingSocialMedia.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/FormSettingWebmaster.php');

        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Core', 'Database/Migrations'));

        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->pushMiddleware(\SimpleCMS\Core\Http\Middleware\HttpsProtocol::class);

        $this->app['router']->aliasMiddleware('permission', \SimpleCMS\Core\Http\Middleware\PermissionMiddleware::class);
        $this->app['router']->aliasMiddleware('guest', \SimpleCMS\Core\Http\Middleware\RedirectIfAuthenticated::class);

        /*$this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            Handler::class
        );*/
//        Blade::setRawTags('[!!', '!!]');
//        Blade::setContentTags('[[', ']]');
//        Blade::setEscapedContentTags('[[[', ']]]');

        // Register blade directives:
        $this->addToBlade(['dd', 'dd(%s);']);
        $this->addToBlade(['dv', 'dd(get_defined_vars()[%s]);', 'dd(get_defined_vars()["__data"]);']);
        $this->addToBlade(['d', 'dump(%s);']);

        $this->addToBlade(['coreAsset', 'Core::asset()->absUrl(%s);']);

        $this->addToBlade(['coreStyles', 'Core::asset()->container(%s)->styles();', 'Core::asset()->styles();']);
        $this->addToBlade(['coreScriptsTop', 'Core::asset()->container(%s)->scriptsTop();', 'Core::asset()->scriptsTop();']);
        $this->addToBlade(['coreScripts', 'Core::asset()->container(%s)->scripts();', 'Core::asset()->scripts();']);

        $locale = simple_cms_setting('locale', 'id');
        if (env('APP_LOCALE') != $locale){
            setEnvironment('APP_LOCALE', $locale);
        }

//        if (!$this->app->runningInConsole()) {
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
        $this->registerConfig();

        /*if ( class_exists(\Collective\Html\HtmlServiceProvider::class) ) {
            $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        }*/

        if (class_exists(\SimpleCMS\Core\Hooks\EventServiceProvider::class)){
            $this->app->register(\SimpleCMS\Core\Hooks\EventServiceProvider::class);
        }
        if (class_exists(\SimpleCMS\Core\Hooks\EventBladeServiceProvider::class)){
            $this->app->register(\SimpleCMS\Core\Hooks\EventBladeServiceProvider::class);
        }

        $this->app->singleton('simple_cms_setting', function($app)
        {
            return new \SimpleCMS\Core\Supports\CoreSetting($app['cache']);
        });
        $this->app->singleton('core_asset', function($app)
        {
            return new CoreAsset();
        });

        $this->app->singleton('core', function($app)
        {
            return new Core($app['core_asset'], $app['simple_cms_setting']);
        });

        $this->app->alias('core', \SimpleCMS\Core\Contracts\Core::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Core', \SimpleCMS\Core\Facades\Core::class);
        if ( class_exists(\Nwidart\Modules\Facades\Module::class) ) {
            $loader->alias('Cms', \Nwidart\Modules\Facades\Module::class);
        }
        if ( class_exists(\Collective\Html\HtmlFacade::class) ) {
            $loader->alias('Form', \Collective\Html\FormFacade::class);
            $loader->alias('Html', \Collective\Html\HtmlFacade::class);
            $loader->alias('HTML', \Collective\Html\HtmlFacade::class);
        }
        if ( class_exists(\Maatwebsite\Excel\Facades\Excel::class) ) {
            $loader->alias('Excel', \Maatwebsite\Excel\Facades\Excel::class);
        }
        if ( class_exists(\SimpleCMS\Core\Hooks\Facades\Events::class) ) {
            $loader->alias('Hook', \SimpleCMS\Core\Hooks\Facades\Events::class);
        }
        if ( class_exists(\Barryvdh\DomPDF\Facade::class) ) {
            $loader->alias('PDF', \Barryvdh\DomPDF\Facade::class);
        }

        $this->registerModulePublishCommand();
        $this->registerModuleAssetsLinkCommand();
        // Assign commands:
        $this->commands(
            'simple_cms.module.publish',
            'simple_cms.module.link'
        );
        /** This register Hook Helpers if have  */
        $this->app['files']->requireOnce(__DIR__ . '/../Hooks/HookHelper.php');

        /** This register all Helpers if have  */
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/SettingHelper.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/MessagesHelper.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/Helpers.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/Libraries.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/ModuleHelper.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/GeneralHookBackend.php');

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        /* This register all Config if have */
        $configs = $this->app['files']->glob(__DIR__.'/../Config/*.php');
        foreach ($configs as $config) {
            $config = str_replace('.php','',$config);
            $config = explode('/',$config);
            $config = end($config);
            $file_config = $config.'.php';
            if($config=='config'){
                $this->publishes([
                    __DIR__ . '/../Config/' . $file_config => config_path('core.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                __DIR__ . '/../Config/' . $file_config, ($config=='config' ? 'core' : $config)
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
        $viewPath = resource_path('views/simple_cms/core');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/core';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'core');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'core');
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
            app(Factory::class)->load(module_path('Core', 'Database/factories'));
        }
    }

    /**
     * Register command ModulePublishCommand.
     *
     * @return void
     */
    public function registerModulePublishCommand()
    {
        $this->app->singleton('simple_cms.module.publish', function($app)
        {
            return new \SimpleCMS\Core\Commands\ModulePublishCommand();
        });
    }

    /**
     * Register command ModuleAssetsLinkCommand.
     *
     * @return void
     */
    public function registerModuleAssetsLinkCommand()
    {
        $this->app->singleton('simple_cms.module.link', function($app)
        {
            return new \SimpleCMS\Core\Commands\ModuleAssetsLinkCommand();
        });
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['core_asset', 'simple_cms_setting', 'core'];
    }
}
