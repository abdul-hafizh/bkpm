<?php

use SimpleCMS\EloquentViewable\Contracts\Viewable;
use SimpleCMS\EloquentViewable\Contracts\Views;
use Illuminate\Container\Container;

if (! function_exists('views')) {
    function views($viewable)
    {
        $builder = Container::getInstance()->make(Views::class);

        if (is_string($viewable)) {
            $model = Container::getInstance()->make($viewable);

            if ($model instanceof Viewable) {
                $viewable = $model;
            }
        }

        return $builder->forViewable($viewable);
    }
}
