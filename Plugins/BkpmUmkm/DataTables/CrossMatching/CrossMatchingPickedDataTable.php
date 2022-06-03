<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\CrossMatching;

use Carbon\Carbon;
use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\KemitraanModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CrossMatchingPickedDataTable extends DataTable
{
    protected $dataTableID = 'crossMatchingPickedDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_COMPANY;
    protected $category_reverse = CATEGORY_UMKM;
    protected $company_id;
    protected $company;
    protected $periode;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
        $this->company_id = encrypt_decrypt(request()->route()->parameter('company_id'), 2);
        $category_company = request()->route()->parameter('company');
        switch ($category_company){
            case CATEGORY_COMPANY:
                $this->company_category = CATEGORY_COMPANY;
                $this->category_reverse = CATEGORY_UMKM;
                break;
            case CATEGORY_UMKM:
                $this->company_category = CATEGORY_UMKM;
                $this->category_reverse = CATEGORY_COMPANY;
                break;
        }
        $this->company = CompanyModel::where('id', $this->company_id)->first();
        $this->periode = '2022';
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn("{$this->category_reverse}.name", function($q){
                $name = $q->{$this->category_reverse}->name;
                if ( hasRoute("{$this->identifier}.backend.survey.detail_survey") && hasRoutePermission("{$this->identifier}.backend.survey.detail_survey") && ($q->{$this->category_reverse}->survey && $q->{$this->category_reverse}->survey->survey_result) ){
                    $name = '<a href="javascript:void(0);" class="show_modal_ex_lg" data-action="'. route("{$this->identifier}.backend.survey.detail_survey", ['company' => $this->category_reverse, 'survey'=>encrypt_decrypt($q->{$this->category_reverse}->survey->id), 'in_modal' => true]) .'" data-method="GET" title="'.trans("label.survey_detail_survey_{$this->category_reverse}").'">'. $q->{$this->category_reverse}->name .'</a>';
                }
                $html = '<div class="user-block">
                                <span class="username ml-1"><a>'. $name .'</a></span>
                                <span class="description ml-1">
                                    <i class="fas fa-sort-numeric-up"></i> ' . ($q->{$this->category_reverse}->nib ? $q->{$this->category_reverse}->nib : '-') . '
                                    <br/><i class="fas fa-map-marker-alt"></i> ' . ($q->{$this->category_reverse}->provinsi ? $q->{$this->category_reverse}->provinsi->nama_provinsi : '-') . '
                                    '. (!empty($q->{$this->category_reverse}->name_pic) ? '<br/><i class="fas fa-user"></i> ' . $q->{$this->category_reverse}->name_pic : '') . '
                                    '. (!empty($q->{$this->category_reverse}->email_pic) ? '<br/><i class="fas fa-envelope"></i> ' . $q->{$this->category_reverse}->email_pic : '') . '
                                    '. (!empty($q->{$this->category_reverse}->phone_pic) ? '<br/><i class="fas fa-phone"></i> ' . $q->{$this->category_reverse}->phone_pic : '') . '
                                </span>
                            </div>';
                return $html;
            })
            ->addColumn('statusRaw', function ($q){
                $status = trans("label.cross_matching_status_{$q->{"{$this->category_reverse}_status"}}");
                $style_button = ($q->{"{$this->category_reverse}_status"} == 'bersedia' ? 'success' : ($q->{"{$this->category_reverse}_status"} == 'tidak_bersedia' ? 'warning' : 'secondary'));
                $status = '<div class="btn-group-sm">
                                <button type="button" class="btn btn-'.$style_button.' dropdown-toggle btn-sm" data-toggle="dropdown">'. $status .'</button>';
                if (hasRoutePermission("{$this->identifier}.backend.cross_matching.change_status") ) {
                    $status .= ' <div class="dropdown-menu  dropdown-menu-right">
                                    '. ( $q->{"{$this->category_reverse}_status"} == 'bersedia' ? '<a class="dropdown-item eventCrossMatchingChangeStatus text-info" href="javascript:void(0);" data-selecteddatatable="'.$this->dataTableID.'" data-action="'. route("{$this->identifier}.backend.cross_matching.change_status", ['company'=>$this->company_category, 'company_id'=>encrypt_decrypt($this->company_id)]) .'" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'target_to' => encrypt_decrypt($this->category_reverse), 'target_id' => encrypt_decrypt($q->{$this->category_reverse}->id), 'status' => encrypt_decrypt('tidak_bersedia')]) .'\' data-with-input="true" title="'. trans("label.cross_matching_status_tidak_bersedia") .'">'. trans("label.cross_matching_status_tidak_bersedia") .'</a>' : '<a class="dropdown-item eventCrossMatchingChangeStatus text-info" href="javascript:void(0);" data-selecteddatatable="'.$this->dataTableID.'" data-action="'. route("{$this->identifier}.backend.cross_matching.change_status", ['company'=>$this->company_category, 'company_id'=>encrypt_decrypt($this->company_id)]) .'" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'target_to' => encrypt_decrypt($this->category_reverse), 'target_id' => encrypt_decrypt($q->{$this->category_reverse}->id), 'status' => encrypt_decrypt('bersedia')]) .'\' title="'. trans("label.cross_matching_status_bersedia") .'">'. trans("label.cross_matching_status_bersedia") .'</a>') .'
                                </div>';
                }
                $status .= '</div>';
                if (!empty($q->{"{$this->category_reverse}_status_description"})){
                    $status .= '<div class="form-group"><label>Keterangan:</label>';
                    $status .= '<p>'. nl2br($q->{"{$this->category_reverse}_status_description"}) .'</p>';
                    $status .= '</div>';
                }
                return $status;
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group-vertical btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.cross_matching.force_delete") && hasRoutePermission("{$this->identifier}.backend.cross_matching.force_delete")){
                    $html .= '<a class="btn btn-xs btn-danger mt-1 eventCrossMatchingForceDelete" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.cross_matching.force_delete", ['company'=>$this->company_category, 'company_id'=>encrypt_decrypt($this->company_id)]).'" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id)]) .'\' title="' . trans('label.cross_matching_force_delete') . '"><i class="fas fa-trash"></i> '. trans('label.cross_matching_force_delete') .'</a>';
                }
                $html .= '</div>';

                return $html;
            })
            ->rawColumns(["{$this->category_reverse}.name", 'statusRaw', 'action'])
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Plugins\BkpmUmkm\Models\KemitraanModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(KemitraanModel $model)
    {
        $model = $model->where("kemitraan.{$this->company_category}_id", $this->company_id)
            ->with(["{$this->category_reverse}" => function($q){
                return $q->with(['survey' => function($q){
                    return $q->with(['survey_result'])->whereYear('surveys.created_at', $this->periode);
                }]);
            }])->whereYear('kemitraan.created_at', $this->periode);
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [
            Button::make('reset'),
            Button::make('reload')
        ];
        $script = <<<CDATA
                    var formData = $("form#{$this->dataTableID}Form", document).find("input, select").serializeArray();
                    $.each(formData, function(i, obj){
                        data[obj.name] = obj.value;
                    });
CDATA;

        return $this->builder()
            ->addTableClass('table table-bordered table-hover table-sm')
            ->setTableId($this->dataTableID)
            ->columns($this->getColumns())
            ->minifiedAjax(route("{$this->identifier}.backend.cross_matching.datatable_picked", ['company' => $this->company_category, 'company_id' => encrypt_decrypt($this->company_id)]),$script)
            ->dom(dataTableDom('Bflrtip'))
            ->buttons($buttons);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('no_index', 'no_index')->title('No')
                ->width('1%')->addClass('text-center')
                ->orderable(false)->searchable(false),
            Column::make("{$this->category_reverse}.name")->title(trans("label.name_{$this->category_reverse}")),
            Column::make("{$this->category_reverse}.nib")->visible(false),
            /*Column::make("statusRaw")->title(trans('label.status'))->orderable(false)->searchable(false),*/
            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('10%')
            //->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return "cross_matching_available_{$this->category_reverse}_" . date('YmdHis');
    }
}
