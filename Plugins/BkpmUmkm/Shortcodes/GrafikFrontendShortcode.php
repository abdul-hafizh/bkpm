<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * Website : https://whendy.net
 * LinkedIn : https://www.linkedin.com/in/ahmad-windi-wijayanto/
 * --------- 11/22/20, 5:29 PM ---------
 */

namespace Plugins\BkpmUmkm\Shortcodes;

use Plugins\BkpmUmkm\DataTables\Kemitraan\FrontKemitraanDataTable;
use SimpleCMS\Shortcode\Shortcode;

class GrafikFrontendShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [GrafikFronted] shortcode for grafik.';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[GrafikFronted]';

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
        if (isset($this->atts['class']) && !empty($this->atts['class'])) {
            $this->attributes['class'] .= $this->atts['class'];
            unset($this->atts['class']);
        }
        $params['periodes'] = list_years();
        $this->attributes = array_merge($this->attributes, $this->atts);
        /*\Theme::asset()->container('head')->writeContent('library_datatables_css', library_datatables('css'));*/
        $scriptRemoveEventDataTableLoadDataTrashedForm = '<script>const urlLoadDataGrafikFrontend = "'. route('simple_cms.plugins.bkpmumkm.grafik_frontend') .'"</script>';
        \Theme::asset()->container('footer')->writeContent('grafik_frontend_js', $scriptRemoveEventDataTableLoadDataTrashedForm . plugins_script('bkpmumkm', 'frontend/js/grafik.js'));
        return $this->view('simple_cms.plugins.bkpmumkm::grafik_frontend', $params);
    }
}
