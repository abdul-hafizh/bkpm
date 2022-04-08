<?php

namespace SimpleCMS\Blog\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Blog\Services\Post;
use SimpleCMS\Core\Supports\CoreSupport;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  */
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/helper.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/GeneralHookBackend.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/FormInputSetting.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/ContactForm.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/dashboard.php');

        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Blog', 'Database/Migrations'));

        $this->app['shortcodes']->add('contact_form', \SimpleCMS\Blog\Supports\ContactFormShortcode::class);

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

        $uri_regex_not_allowed = simple_cms_setting('blog_url_not_allowed', 'backend,admin,auth,wilayah,captcha,archive,category,search,tag');
        $uri_regex_not_allowed = preg_replace('/\s/', '', $uri_regex_not_allowed);
        $uri_regex_not_allowed = explode(',', $uri_regex_not_allowed);

        $this->app['config']->set('blog.url_not_allowed', $uri_regex_not_allowed);

        /* set default seo helper */
        // Title
        $this->app['config']->set('seo-helper.title.default', site_name());
        $this->app['config']->set('seo-helper.title.site-name', site_name());
        $this->app['config']->set('seo-helper.title.separator', '|');
        // Description
        $this->app['config']->set('seo-helper.description.default', site_description());
        // Keyword
        $this->app['config']->set('seo-helper.keywords.default', explode(',',site_keyword()));
        // Misc
//        $this->app['config']->set('seo-helper.misc.default.viewport', '');
//        $this->app['config']->set('seo-helper.misc.default.author', '');
//        $this->app['config']->set('seo-helper.misc.default.publisher', '');
        // Webmasters
        $this->app['config']->set('seo-helper.webmasters', [
            'google'    => simple_cms_setting('webmaster_google'),
            'bing'      => simple_cms_setting('webmaster_bing'),
            'alexa'     => simple_cms_setting('webmaster_alexa'),
            'pinterest' => simple_cms_setting('webmaster_pinterest'),
            'yandex'    => simple_cms_setting('webmaster_yandex'),
        ]);
        // Twitter
        $this->app['config']->set('seo-helper.twitter.site', simple_cms_setting('twitter_username', 'Whendy_Takashy'));
        $this->app['config']->set('seo-helper.analytics.google', simple_cms_setting('site_g_analytic'));

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Post', \SimpleCMS\Blog\Facades\Post::class);
        $this->registerPost();
    }


    /**
     * Register Post.
     *
     * @return void
     */
    public function registerPost()
    {
        $this->app->singleton('post', function($app)
        {
            return new Post($app['request'], $app['config'], $app['view'], $app['theme']);
        });

        $this->app->alias('post', \SimpleCMS\Blog\Contracts\Post::class);
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
                    module_path('Blog', 'Config/'.$file_config) => config_path('blog.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('Blog', 'Config/'.$file_config), ($config=='config' ? 'blog' : $config)
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
        $viewPath = resource_path('views/simple_cms/blog');

        $sourcePath = module_path('Blog', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/blog';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'blog');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/blog');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'blog');
        } else {
            $this->loadTranslationsFrom(module_path('Blog', 'Resources/lang'), 'blog');
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
            app(Factory::class)->load(module_path('Blog', 'Database/factories'));
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
