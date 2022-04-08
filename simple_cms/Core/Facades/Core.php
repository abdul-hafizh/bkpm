<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/15/20, 8:44 PM ---------
 */

namespace SimpleCMS\Core\Facades;


use Illuminate\Support\Facades\Facade;

class Core extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return \SimpleCMS\Core\Core::class; }
}
