<?php namespace SimpleCMS\Theme\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return \SimpleCMS\Theme\Theme::class; }

}