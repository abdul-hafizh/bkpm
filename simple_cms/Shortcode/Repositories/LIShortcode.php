<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class LIShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [li] shortcode for li list';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[li]text_content[/li]';

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
        $this->attributes = array_merge($this->attributes, $this->atts);
        return '<li' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</li>';
    }
}
