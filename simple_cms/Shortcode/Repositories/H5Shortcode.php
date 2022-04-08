<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class H5Shortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [h5] shortcode for heading 5';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[h5]text_content[/h5]';

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
        return '<h5' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</h5>';
    }
}
