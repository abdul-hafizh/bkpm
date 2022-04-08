<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/15/20, 11:31 PM ---------
 */

namespace SimpleCMS\Widget\Facades;

use Illuminate\Support\Facades\Facade;

class WidgetFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'simple_cms.widget';
    }

    /**
     * Get the widget group object.
     *
     * @param $name
     *
     * @return \SimpleCMS\Widget\WidgetGroup
     */
    public static function group($name)
    {
        return app('simple_cms.widget-group-collection')->group($name);
    }
}
