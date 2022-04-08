<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class H4Shortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [h4] shortcode for heading 4';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[h4]text_content[/h4]';

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
        return '<h4' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</h4>';
    }
}
