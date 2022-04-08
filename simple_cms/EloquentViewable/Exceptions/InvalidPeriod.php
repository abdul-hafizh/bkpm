<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 8:49 PM ---------
 */

declare(strict_types=1);

namespace SimpleCMS\EloquentViewable\Exceptions;

use DateTime;
use Exception;

class InvalidPeriod extends Exception
{
    /**
     * Start date time cannot be after end eate time.
     *
     * @param  \DateTime  $startDateTime
     * @param  \DateTime  $endDateTime
     * @return static
     */
    public static function startDateTimeCannotBeAfterEndDateTime(DateTime $startDateTime, DateTime $endDateTime)
    {
        return new static("Start date `{$startDateTime->format('Y-m-d')}` cannot be after end date `{$endDateTime->format('Y-m-d')}`.");
    }
}
