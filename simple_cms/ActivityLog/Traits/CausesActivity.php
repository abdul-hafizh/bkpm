<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 9:37 PM ---------
 */

namespace SimpleCMS\ActivityLog\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use SimpleCMS\ActivityLog\Providers\ActivityLogServiceProvider;

trait CausesActivity
{
    public function actions(): MorphMany
    {
        return $this->morphMany(
            ActivitylogServiceProvider::determineActivityModel(),
            'causer'
        );
    }
}
