<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class DivShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [div] shortcode for tag div';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[div]text_content[/div]';

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
        return '<div ' . \HTML::attributes($this->atts()). '>'. shortcodes($content) . '</div>';
    }
}
