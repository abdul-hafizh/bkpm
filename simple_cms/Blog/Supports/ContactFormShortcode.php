<?php

namespace SimpleCMS\Blog\Supports;

use SimpleCMS\Shortcode\Shortcode;

class ContactFormShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [contact_form] shortcode for template Contact Form';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[contact_form]';

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
        return apply_filter('simple_cms_theme_contact_form');
    }

}
