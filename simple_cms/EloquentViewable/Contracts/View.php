<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 8:46 PM ---------
 */

declare(strict_types=1);


namespace SimpleCMS\EloquentViewable\Contracts;

use Illuminate\Database\Eloquent\Builder;
use SimpleCMS\EloquentViewable\Support\Period;
use Illuminate\Database\Eloquent\Relations\MorphTo;

interface View
{
    /**
     * Get the viewable model to which this View belongs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function viewable(): MorphTo;

    /**
     * Scope a query to only include views within the period.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param \SimpleCMS\EloquentViewable\Support\Period $period
     * @param  mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithinPeriod(Builder $query, Period $period);
}
