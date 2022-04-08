<?php

namespace SimpleCMS\Shortcode\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\HtmlString;
use SimpleCMS\Shortcode\Manager;

/**
 * @method static Manager share(string $key, $value)
 * @method static mixed shared($key = null, $value = null)
 * @method static Manager add($name, $callable = null)
 * @method static Manager remove($name)
 * @method static array registered()
 * @method static array rendered()
 * @method static HtmlString render($content)
 *
 * @see \SimpleCMS\Shortcode\Manager
 */
class Shortcodes extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shortcodes';
    }
}
