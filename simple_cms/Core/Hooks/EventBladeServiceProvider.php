<?php

namespace SimpleCMS\Core\Hooks;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class EventBladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Adds a directive in Blade for actions
         */
        Blade::directive('hookAction', function ($expression) {
            return "<?php echo \Hook::action({$expression});?>";
        });

        /*
         * Adds a directive in Blade for filters
         */
        Blade::directive('hookFilter', function ($expression) {
            return "<?php echo \Hook::filter({$expression}); ?>";
        });
    }
}
