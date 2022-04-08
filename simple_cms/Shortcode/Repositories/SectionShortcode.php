<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class SectionShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [section] shortcode for section tag html';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[section]text_content[/section]';

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
        return '<section' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</section>';
    }
}
