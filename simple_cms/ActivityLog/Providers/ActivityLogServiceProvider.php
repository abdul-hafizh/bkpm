<?php

namespace SimpleCMS\ActivityLog\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use SimpleCMS\ActivityLog\ActivityLogger;
use SimpleCMS\ActivityLog\ActivityLogStatus;
use SimpleCMS\ActivityLog\CleanActivityLogCommand;
use SimpleCMS\Core\Supports\CoreSupport;
use SimpleCMS\ActivityLog\Contracts\Activity;
use SimpleCMS\ActivityLog\Contracts\Activity as ActivityContract;
use SimpleCMS\ActivityLog\Exceptions\InvalidConfiguration;
use SimpleCMS\ActivityLog\Models\Activity as ActivityModel;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  */
        CoreSupport::helpers_autoload(module_path('ActivityLog','Helpers'));

        $this->registerTranslations();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path('ActivityLog', 'Database/Migrations'));

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
        $this->registerConfig();
        $this->app->bind('command.activitylog:clean', CleanActivityLogCommand::class);

        $this->commands([
            'command.activitylog:clean',
        ]);

        $this->app->bind(ActivityLogger::class);

        $this->app->singleton(ActivityLogStatus::class);

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
                    module_path('ActivityLog', 'Config/'.$file_config) => config_path('activitylog.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('ActivityLog', 'Config/'.$file_config), ($config=='config' ? 'activitylog' : $config)
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
        $viewPath = resource_path('views/simple_cms/activitylog');

        $sourcePath = module_path('ActivityLog', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/activitylog';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'activitylog');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/activitylog');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'activitylog');
        } else {
            $this->loadTranslationsFrom(module_path('ActivityLog', 'Resources/lang'), 'activitylog');
        }
    }

    public static function determineActivityModel(): string
    {
        $activityModel = config('activitylog.activity_model') ?? ActivityModel::class;
        if (! is_a($activityModel, Activity::class, true)
            || ! is_a($activityModel, Model::class, true)) {
            throw InvalidConfiguration::modelIsNotValid($activityModel);
        }

        return $activityModel;
    }

    public static function getActivityModelInstance(): ActivityContract
    {
        $activityModelClassName = self::determineActivityModel();

        return new $activityModelClassName();
    }
}
