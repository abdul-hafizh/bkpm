<?php

namespace Plugins\Reference\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	/**
     * The plugin namespace to assume when generating URLs to actions.
     *
     * @var string
     */
	protected $pluginNamespace = 'Plugins\Reference\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 */
	public function boot()
	{
		parent::boot();
	}

	/**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->pluginNamespace)
            ->group(base_path('Plugins/Reference/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->pluginNamespace)
            ->group(base_path('Plugins/Reference/Routes/api.php'));
    }
}
