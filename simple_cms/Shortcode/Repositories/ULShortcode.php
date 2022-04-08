<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class ULShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [ul] shortcode for ul list';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[ul]text_content[/ul]';

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
        return '<ul' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</ul>';
    }
}
