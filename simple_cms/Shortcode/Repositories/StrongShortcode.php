<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class StrongShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [strong] shortcode for text bold / strong';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[strong]text_content[/strong]';

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
        return '<strong' . \HTML::attributes($this->atts()). '>' . shortcodes($content) . '</strong>';
    }
}
