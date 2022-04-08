<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 8:49 PM ---------
 */

declare(strict_types=1);

namespace SimpleCMS\EloquentViewable\Facades;

use Illuminate\Support\Facades\Facade;
use SimpleCMS\EloquentViewable\Contracts\Views as ViewsContract;

/**
 * @see \SimpleCMS\EloquentViewable\Views
 * @codeCoverageIgnore
 */
class ViewsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ViewsContract::class;
    }
}
