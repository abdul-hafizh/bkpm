<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class PdfViewerShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [pdf_view src=""] shortcode for embed/view pdf.';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[pdf_view src=""]';

    /**
     * @var array Shortcode attributes with default values
     */
    public $attributes = [
        'src' => '',
        'style' => 'width: 100%; height: 950px; ',
        'type' => 'application/pdf'
    ];

    /**
     * Render shortcode.
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        if (isset($this->atts['src']) && !empty($this->atts['src'])) {

            if (isset($this->atts['style'])) {
                $this->attributes['style'] .= $this->atts['style'];
                unset($this->atts['style']);
            }

            if (isset($this->atts['type'])) {
                $this->attributes['type'] = $this->atts['type'];
                unset($this->atts['type']);
            }

            $this->attributes = array_merge($this->attributes, $this->atts);

            $attributes_object = $this->attributes;

            $srcScheme = parse_url($attributes_object['src'], PHP_URL_SCHEME);
            if(!$srcScheme){
                $setScheme = (simple_cms_setting('force_https') OR request()->secure() ? 'https://': 'http://' );
                $attributes_object['src'] = $setScheme . str_replace('//', '', $attributes_object['src']);
            }

            $attributes_object['data'] = $attributes_object['src'];
            unset($attributes_object['src']);

            return '<object' . \HTML::attributes($attributes_object) . '><embed'. \HTML::attributes($this->attributes()) .' /></object>';
        }
        return '';
    }
}
