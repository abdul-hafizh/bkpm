<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class RowShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [row] shortcode for div class row';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[row]text_content[/row]';

    /**
     * @var array Shortcode attributes with default values
     */
    public $attributes = [
        'class' => 'row'
    ];

    /**
     * Render shortcode.
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        if (isset($this->atts['class'])){
            $this->attributes['class'] .= ' ' . $this->atts['class'];
            unset($this->atts['class']);
        }
        $this->attributes = array_merge($this->attributes, $this->atts);
        return '<div' . \HTML::attributes($this->atts()). '>'. shortcodes($content) . '</div>';
    }
}
