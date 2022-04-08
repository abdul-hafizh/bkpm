<?php

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class GoogleDocsViewerShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [google_docs_view src=""] shortcode for embed/view pdf,doc,excel,ppt if support';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[google_docs_view src=""]';

    /**
     * @var array Shortcode attributes with default values
     */
    public $attributes = [
        'src' => 'https://docs.google.com/viewer?url=%s&embedded=true',
        'style' => 'width: 100%; height: 950px; ',
        'frameborder' => 0
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

            $src = $this->atts['src'];
            $srcScheme = parse_url($src, PHP_URL_SCHEME);
            if(!$srcScheme){
                $src = 'https://' . str_replace('//', '', $src);
            }
            $this->attributes['src'] = sprintf($this->attributes['src'], $src);
            unset($this->atts['src']);

            if (isset($this->atts['style'])) {
                $this->attributes['style'] .= $this->atts['style'];
                unset($this->atts['style']);
            }

            $this->attributes = array_merge($this->attributes, $this->atts);

            return '<iframe' . \HTML::attributes($this->attributes()) . '></iframe>';
        }
        return '';
    }
}
