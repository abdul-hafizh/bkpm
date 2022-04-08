<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class H2Shortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [h2] shortcode for heading 2';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[h2]text_content[/h2]';

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
        return '<h2' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</h2>';
    }
}
