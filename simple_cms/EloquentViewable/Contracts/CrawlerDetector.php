<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 8:46 PM ---------
 */

declare(strict_types=1);


namespace SimpleCMS\EloquentViewable\Contracts;

interface CrawlerDetector
{
    /**
     * Determine if the current user is a crawler.
     *
     * @return bool
     */
    public function isCrawler(): bool;
}
