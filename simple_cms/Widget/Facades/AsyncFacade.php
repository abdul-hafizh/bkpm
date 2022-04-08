<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/15/20, 11:31 PM ---------
 */

namespace SimpleCMS\Widget\Facades;

class AsyncFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'simple_cms.async-widget';
    }
}
