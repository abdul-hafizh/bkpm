<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class H1Shortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [h1] shortcode for heading 1';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[h1]text_content[/h1]';

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
        return '<h1' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</h1>';
    }
}
