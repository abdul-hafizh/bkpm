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

class DataTableKemitraanShortcode extends Shortcode
{
    /**
     * @var string Shortcode description
     */
    public $description = 'Render [DataTableKemitraan] shortcode for list Data Kemitraan.';

    /**
     * @var string Shortcode usage
     */
    public $usage = '[DataTableKemitraan]';

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
        $periodes = [];
        foreach (list_years() as $y) {
            $periodes[] = $y;
        }
        $datatable = new FrontKemitraanDataTable();
        $datatable = $datatable->html();
        $this->attributes = array_merge($this->attributes, $this->atts);
        \Theme::asset()->container('head')->writeContent('library_datatables_css', library_datatables('css'));
        $script = 'let dataTableID = $(document).find(\'table.dataTable\').attr(\'id\'),
                periode = \'<div class="form-group col-2">\';
            periode += \'<label>Periode</label>\';
            periode += \'<select class="form-control form-control-sm eventDataTableLoadDataTrashedForm" name="periode">\';
            $.each(periodes, function(idx, val){
                periode += \'<option value="\'+ val +\'">\'+ val +\'</option>\';
            });
            periode += \'</select>\';
            periode += \'</div>\';

            $(`form#${dataTableID}Form`).append(periode);';
        $scriptRemoveEventDataTableLoadDataTrashedForm = '<script>const periodes = '. json_encode($periodes).';$(document).ready(function(){ $(".dt-buttons", document).remove();$(".selectTrashedDatable", document).remove(); '. $script .'})</script>';
        \Theme::asset()->container('footer')->writeContent('library_datatables_js', library_datatables('js') . $datatable->scripts() . module_script('core','js/events.js') . $scriptRemoveEventDataTableLoadDataTrashedForm);
        return $datatable->table();
    }
}
