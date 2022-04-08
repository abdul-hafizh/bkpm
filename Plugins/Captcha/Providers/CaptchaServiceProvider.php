<?php

namespace Plugins\Captcha\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory as ValidationFactory;

class CaptchaServiceProvider extends ServiceProvider
{
	/**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/helpers.php');

        // Bind captcha
        $this->app->bind('captcha', function ($app) {
            return new \Plugins\Captcha\Captcha(
                $app['Illuminate\Filesystem\Filesystem'],
                $app['Illuminate\Contracts\Config\Repository'],
                $app['Intervention\Image\ImageManager'],
                $app['Illuminate\Session\Store'],
                $app['Illuminate\Hashing\BcryptHasher'],
                $app['Illuminate\Support\Str']
            );
        });

        $aliases['Captcha'] = \Plugins\Captcha\Facades\Captcha::class;
        AliasLoader::getInstance($aliases)->register();

        $this->publishAssets();
    }

	/**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerViews();

        // HTTP routing
        if (strpos($this->app->version(), 'Lumen') !== false) {
            /* @var Router $router */
            $router = $this->app;
            $router->get('/captcha[/api/{config}]', '\Plugins\Captcha\LumenCaptchaController@getCaptchaApi');
            $router->get('/captcha[/{config}]', '\Plugins\Captcha\LumenCaptchaController@getCaptcha');
        } else {
            /* @var Router $router */
            $router = $this->app['router'];
            if ((double)$this->app->version() >= 5.2) {
                $router->group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['web', 'localize']], function() use($router){
                    $router->get('/captcha/api/{config?}', '\Plugins\Captcha\CaptchaController@getCaptchaApi')->middleware('web');
                    $router->get('/captcha/{config?}', '\Plugins\Captcha\CaptchaController@getCaptcha')->middleware('web');
                });
            } else {
//                if (!$this->app->runningInConsole()) {
                    $router->group(['prefix' => \UriLocalizer::localeFromRequest(), 'middleware' => ['web', 'localize']], function () use ($router) {
                        $router->get('/captcha/api/{config?}', '\Plugins\Captcha\CaptchaController@getCaptchaApi');
                        $router->get('/captcha/{config?}', '\Plugins\Captcha\CaptchaController@getCaptcha');
                    });
//                }
            }
        }

        /* @var ValidationFactory $validator */
        $validator = $this->app['validator'];

        // Validator extensions
        $validator->extend('captcha', function ($attribute, $value, $parameters) {
            return captcha_check($value);
        });

        // Validator extensions
        $validator->extend('captcha_api', function ($attribute, $value, $parameters) {
            return captcha_api_check($value, $parameters[0]);
        });

        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/hook_action_filter.php');

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $path_config = base_path('Plugins/Captcha/Config');
        $this->mergeConfigFrom(
            $path_config . '/config.php', 'plugins.captcha'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->app['view']->addNamespace('captcha', base_path('Plugins/Captcha/Resources/views'));
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->app['translator']->addNamespace('captcha', base_path('Plugins/Captcha/Resources/lang'));
    }

    /**
     * Publish/Link assets to public folder.
     */
    public function publishAssets()
    {
        $link_path = public_path('plugins/captcha');
        $target_path = base_path('Plugins/Captcha/Resources/assets');
        if (!$this->app['files']->exists($link_path) && $this->app['files']->exists($target_path)) {
            $this->app->make('files')->link($target_path, $link_path);
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
