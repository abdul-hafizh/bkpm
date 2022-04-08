<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/15/20, 11:31 PM ---------
 */

namespace SimpleCMS\Widget\Facades;

use Illuminate\Support\Facades\Facade;

class WidgetGroupFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'simple_cms.widget-group-collection';
    }
}
