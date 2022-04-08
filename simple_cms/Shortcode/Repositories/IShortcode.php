<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class IShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [i] shortcode for italic';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[i]text_content[/i]';

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
        return '<i' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</i>';
    }
}
