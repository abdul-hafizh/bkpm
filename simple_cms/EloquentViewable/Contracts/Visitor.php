<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 03 May 2020 09.24 ---------
 */

declare(strict_types=1);

namespace SimpleCMS\EloquentViewable\Contracts;


interface Visitor
{
    /**
     * Get the unique ID that represent's the visitor.
     *
     * @return string
     */
    public function id(): string;

    /**
     * Get the visitor's IP address.
     *
     * @return string|null
     */
    public function ip(): string;

    /**
     * Determine if the visitor has a "Do Not Track" header.
     *
     * @return bool
     */
    public function hasDoNotTrackHeader(): bool;

    /**
     * Determine if the visitor is a crawler.
     *
     * @return bool
     */
    public function isCrawler(): bool;
}