<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class H6Shortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [h6] shortcode for heading 6';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[h6]text_content[/h6]';

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
        return '<h6' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</h6>';
    }
}
