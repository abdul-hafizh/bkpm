<?php namespace SimpleCMS\Core\Facades;

use Illuminate\Support\Facades\Facade;

class CoreAsset extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'core_asset'; }

}
