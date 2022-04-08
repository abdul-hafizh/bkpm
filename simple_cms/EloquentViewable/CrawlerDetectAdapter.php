<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 8:58 PM ---------
 */

declare(strict_types=1);


namespace SimpleCMS\EloquentViewable;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use SimpleCMS\EloquentViewable\Contracts\CrawlerDetector;

class CrawlerDetectAdapter implements CrawlerDetector
{
    /**
     * CrawlerDetect instance.
     *
     * @var \Jaybizzle\CrawlerDetect\CrawlerDetect
     */
    private $detector;

    /**
     * Create a new CrawlerDetector instance.
     *
     * @param  \Jaybizzle\CrawlerDetect\CrawlerDetect  $detector
     * @return void
     */
    public function __construct(CrawlerDetect $detector)
    {
        $this->detector = $detector;
    }

    /**
     * Determine if the current user is a crawler.
     *
     * @return bool
     */
    public function isCrawler(): bool
    {
        return $this->detector->isCrawler();
    }
}
