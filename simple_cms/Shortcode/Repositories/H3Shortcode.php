<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class H3Shortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [h3] shortcode for heading 3';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[h3]text_content[/h3]';

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
        return '<h3' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</h3>';
    }
}
