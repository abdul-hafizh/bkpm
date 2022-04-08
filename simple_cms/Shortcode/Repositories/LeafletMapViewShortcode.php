<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * Website : https://whendy.net
 * LinkedIn : https://www.linkedin.com/in/ahmad-windi-wijayanto/
 * --------- 11/22/20, 5:29 PM ---------
 */

namespace SimpleCMS\Shortcode\Repositories;

use SimpleCMS\Shortcode\Shortcode;

class LeafletMapViewShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [leaflet_map_view id="" longitude="" latitude=""] shortcode for embed/view leaflet map.';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[leaflet_map_view id="" longitude="" latitude=""]';

    /**
     * @var array Shortcode attributes with default values
     */
    public $attributes = [
        'id'    => 'openMap',
        'class' => 'sizeOpenMap openMapView ',
        'data-latitude' => '',
        'data-longitude'=> ''
    ];

    /**
     * Render shortcode.
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        $map_latitude = simple_cms_setting('map_latitude', '');
        $map_longitude = simple_cms_setting('map_longitude', '');
        $show_map = false;
        if (isset($this->atts['class']) && !empty($this->atts['class'])) {
            $this->attributes['class'] .= $this->atts['class'];
            unset($this->atts['class']);
        }

        if ( (isset($this->atts['latitude']) && !empty($this->atts['latitude'])) && (isset($this->atts['longitude']) && !empty($this->atts['longitude'])) ) {
            $show_map = true;
            if (isset($this->atts['latitude'])) {
                $this->attributes['data-latitude'] = $this->atts['latitude'];
                unset($this->atts['latitude']);
            }
            if (isset($this->atts['longitude'])) {
                $this->attributes['data-longitude'] = $this->atts['longitude'];
                unset($this->atts['longitude']);
            }
        }elseif (!empty($map_latitude) && !empty($map_longitude)){
            $show_map = true;
            $this->attributes['data-latitude'] = $map_latitude;
            $this->attributes['data-longitude'] = $map_longitude;
        }

        if ($show_map) {
            $this->attributes = array_merge($this->attributes, $this->atts);
            \Theme::asset()->container('head')->usePath(false)->add('init_map.css', module_asset('core', 'leaflet-map/css/init_map.css'));
            \Theme::asset()->container('head')->usePath(false)->add('leaflet.css', module_asset('core', 'plugins/leaflet/1.6.0/leaflet.css'));
            \Theme::asset()->container('footer')->usePath(false)->add('leaflet.js', module_asset('core', 'plugins/leaflet/1.6.0/leaflet.js'));
            \Theme::asset()->container('footer')->usePath(false)->add('init_view_map.js', module_asset('core', 'leaflet-map/js/init_view_map.js'));
            return '<div class="boxOpenMap"><div ' . \HTML::attributes($this->attributes) . '></div></div>';
        }
        return '';
    }
}
