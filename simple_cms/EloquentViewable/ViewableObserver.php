<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 9:01 PM ---------
 */

declare(strict_types=1);


namespace SimpleCMS\EloquentViewable;

use SimpleCMS\EloquentViewable\Contracts\Viewable;
use Illuminate\Container\Container;

class ViewableObserver
{
    /**
     * Handle the deleted event for the viewable model.
     *
     * @param  \SimpleCMS\EloquentViewable\Contracts\Viewable  $model
     * @return void
     */
    public function deleted(Viewable $viewable)
    {
        if ($this->removeViewsOnDelete($viewable)) {
            Container::getInstance()->make(Views::class)->forViewable($viewable)->destroy();
        }
    }

    /**
     * Determine if should remove views on model delete (defaults to true).
     *
     * @param  \SimpleCMS\EloquentViewable\Contracts\Viewable  $viewable
     * @return bool
     */
    private function removeViewsOnDelete(Viewable $viewable): bool
    {
        return $viewable->removeViewsOnDelete ?? true;
    }
}
