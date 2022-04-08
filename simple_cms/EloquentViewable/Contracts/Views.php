<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 03 May 2020 09.21 ---------
 */

declare(strict_types=1);

namespace SimpleCMS\EloquentViewable\Contracts;

use SimpleCMS\EloquentViewable\Support\Period;

interface Views
{
    /**
     * Set the viewable model.
     *
     * @param  \SimpleCMS\EloquentViewable\Contracts\Viewable|null
     * @return $this
     */
    public function forViewable(Viewable $viewable = null): self;

    /**
     * Get the views count.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Record a view.
     *
     * @return \SimpleCMS\EloquentViewable\Contracts\View|void
     */
    public function record();

    /**
     * Destroy all views of the viewable model.
     *
     * @return void
     */
    public function destroy();

    /**
     * Set a cooldown.
     *
     * @param  \DateTime|\Carbon\Carbon|int  $cooldown
     * @return $this
     */
    public function cooldown($cooldown): self;

    /**
     * Set the period.
     *
     * @param  \SimpleCMS\EloquentViewable\Support\Period
     * @return $this
     */
    public function period($period): self;

    /**
     * Set the collection.
     *
     * @param  string
     * @return $this
     */
    public function collection(string $name): self;

    /**
     * Fetch only unique views.
     *
     * @param  bool  $state
     * @return $this
     */
    public function unique(bool $state = true): self;

    /**
     * Cache the current views count.
     *
     * @param  \DateTime|int|null  $lifetime
     * @return $this
     */
    public function remember($lifetime = null): self;
}