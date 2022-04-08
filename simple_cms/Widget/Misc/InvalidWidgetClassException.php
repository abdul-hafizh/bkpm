<?php

namespace SimpleCMS\Widget\Misc;

use Exception;

class InvalidWidgetClassException extends Exception
{
    /**
     * Exception message.
     *
     * @var string
     */
    protected $message = 'Widget class must extend SimpleCMS\Widget\AbstractWidget class';
}
