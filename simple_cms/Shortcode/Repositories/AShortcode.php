<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class AShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [a] shortcode for link/ a href';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[a]text_content[/a]';

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
        return '<a' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</a>';
    }
}
