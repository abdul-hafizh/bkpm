<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/5/20, 7:42 PM ---------
 */

namespace SimpleCMS\Blog\Facades;

use Illuminate\Support\Facades\Facade;

class Post extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return \SimpleCMS\Blog\Services\Post::class; }
}
