<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 9:36 PM ---------
 */

namespace SimpleCMS\ActivityLog\Exceptions;

use Exception;

class CouldNotLogChanges extends Exception
{
    public static function invalidAttribute($attribute)
    {
        return new static("Cannot log attribute `{$attribute}`. Can only log attributes of a model or a directly related model.");
    }
}
