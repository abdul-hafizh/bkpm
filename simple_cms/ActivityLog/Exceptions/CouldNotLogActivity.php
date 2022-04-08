<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 9:36 PM ---------
 */

namespace SimpleCMS\ActivityLog\Exceptions;

use Exception;

class CouldNotLogActivity extends Exception
{
    public static function couldNotDetermineUser($id)
    {
        return new static("Could not determine a user with identifier `{$id}`.");
    }
}
