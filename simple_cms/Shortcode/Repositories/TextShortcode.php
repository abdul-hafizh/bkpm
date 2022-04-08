<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class TextShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [text] shortcode for break line';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[text]';

    /**
     * @var array Shortcode attributes with default values
     */
    public $attributes = [];

    /**
     * Render shortcode.
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        return app('shortcodes')->render($content);
    }
}
