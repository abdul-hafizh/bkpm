<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class BRShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [br] shortcode for break line';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[br]';

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
        return '<br' . \HTML::attributes($this->atts()). ' />';
    }
}
