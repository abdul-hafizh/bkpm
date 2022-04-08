<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 2:08 AM ---------
 */

namespace SimpleCMS\Plugin\Facades;

use Illuminate\Support\Facades\Facade;

class Plugins extends Facade
{
    /**
     * Get the registered name of the component.
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'plugins';
    }
}
