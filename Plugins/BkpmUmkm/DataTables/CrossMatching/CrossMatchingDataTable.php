<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\CrossMatching;

use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\SurveyModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CrossMatchingDataTable extends DataTable
{
    protected $dataTableID = 'crossMatchingDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_COMPANY;
    protected $category_reverse = CATEGORY_UMKM;
    protected $status = 'bersedia';
    protected $periode;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
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
        $this->periode = (request()->has('periode') && filter(request()->input('periode')) != '' ? filter(request()->input('periode')) : \Carbon\Carbon::now()->format('Y'));
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
            ->editColumn("{$this->company_category}.name", function($q){
                $name = $q->{$this->company_category}->name;
                if ( hasRoute("{$this->identifier}.backend.survey.detail_survey") && hasRoutePermission("{$this->identifier}.backend.survey.detail_survey") && $q->survey_result && !$q->trashed() ){
                    $name = '<a href="javascript:void(0);" class="show_modal_ex_lg" data-action="'. route("{$this->identifier}.backend.survey.detail_survey", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id), 'in_modal' => true]) .'" data-method="GET" title="'.trans("label.survey_detail_survey_{$this->category_reverse}").'">'. $q->{$this->company_category}->name .'</a>';
                }
                return $name;
            })
            ->editColumn("{$this->company_category}.nib", function($q){
                return ($q->{$this->company_category}->nib ? $q->{$this->company_category}->nib : '-');
            })
            ->editColumn("{$this->company_category}.provinsi.nama_provinsi", function($q){
                return ($q->{$this->company_category}->provinsi ? $q->{$this->company_category}->provinsi->nama_provinsi : '-');
            })
            ->editColumn("{$this->company_category}.address", function($q){
                return ($q->{$this->company_category}->address ? nl2br($q->{$this->company_category}->address) : '-');
            })
            ->editColumn("{$this->company_category}.name_pic", function($q){
                $html = '<div class="user-block">
                          <span class="username ml-1"><a>'. $q->{$this->company_category}->name_pic .'</a></span>';
                $html .= '<span class="description ml-1">';
                if (!empty($q->{$this->company_category}->email_pic)){
                    $html .= '<i class="fas fa-envelope"></i> ' . $q->{$this->company_category}->email_pic;
                }
                if (!empty($q->{$this->company_category}->phone_pic)){
                    $html .= '<br/><i class="fas fa-phone"></i> ' . $q->{$this->company_category}->phone_pic;
                }
                $html .= '</span>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('crossMatchingRaw', function ($q){
                $html = '';
                $matches = $q->{$this->company_category}->{"kemitraan_{$this->company_category}_{$this->category_reverse}"};
                if ($matches) {
                    $html .= '<ul class="table-ul">';
                    foreach ($matches as $match) {
                        $html .= '<li>';
                        $status = trans("label.cross_matching_status_{$match->pivot->{"{$this->category_reverse}_status"}}");
                        $style_button = ($match->pivot->{"{$this->category_reverse}_status"} == 'bersedia' ? 'success' : ($match->pivot->{"{$this->category_reverse}_status"} == 'tidak_bersedia' ? 'warning' : 'secondary'));
                        $html .= "<strong>{$match->name}</strong> <br/><span class='badge badge-{$style_button} p-3'>{$status}</span>";
                        if ( hasRoute("{$this->identifier}.backend.cross_matching.activity_log") && hasRoutePermission("{$this->identifier}.backend.cross_matching.activity_log") ){
                            $html .= '<br/><a class="btn btn-xs btn-info mt-1 show_modal_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.cross_matching.activity_log", ['log_name'=>encrypt_decrypt("LOG_CROSS_MATCHING"), 'subject'=>encrypt_decrypt($match->pivot->id)]).'" title="History: ' . $q->{$this->company_category}->name.' -> '. $match->name .'"><i class="fas fa-history"></i> '. trans('label.history') .'</a>';
                        }
                        $html .='</li>';
                    }
                    $html .= '</ul>';
                }
                return $html;
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group-vertical btn-group-xs">';
                // if ( hasRoute("{$this->identifier}.backend.cross_matching.edit") && hasRoutePermission("{$this->identifier}.backend.cross_matching.edit")&& enable_periode( ($this->company_category==CATEGORY_COMPANY ? $q->{$this->company_category}->company_status->created_at : $q->created_at) ) && !$q->trashed()){
		if ( hasRoute("{$this->identifier}.backend.cross_matching.edit") && hasRoutePermission("{$this->identifier}.backend.cross_matching.edit")&& !$q->trashed()){
                    $html .= '<a class="btn btn-xs btn-warning mt-1" href="'.route("{$this->identifier}.backend.cross_matching.edit", ['company'=>$this->company_category, 'company_id'=>encrypt_decrypt($q->{$this->company_category}->id)]).'" title="' . trans('label.cross_matching_edit') . '"><i class="fas fa-edit"></i> '. trans('label.cross_matching_edit') .'</a>';
                }
                $html .= '</div>';

                return $html;
            })
            ->rawColumns(["{$this->company_category}.name", 'survey_result.documents', "{$this->company_category}.name_pic", "{$this->company_category}.address", 'crossMatchingRaw', 'action'])
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Plugins\BkpmUmkm\Models\SurveyModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SurveyModel $model)
    {
        $model = $model->with([
            "{$this->company_category}",
            "{$this->company_category}.pic",
            "{$this->company_category}.provinsi",
            'surveyor',
            "{$this->company_category}.kemitraan_{$this->company_category}_{$this->category_reverse}"=>function($q){
                $q->whereYear('kemitraan.created_at', $this->periode);
            }]);
        switch ($this->user->group_id){
            case GROUP_SURVEYOR:
                $model->where('surveys.surveyor_id', $this->user->id);
                break;
            case GROUP_QC_KORPROV:
                $model->whereHas('surveyor', function ($q){
                    $q->where('users.id_provinsi', $this->user->id_provinsi);
                });
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $model->whereHas('surveyor', function ($q) use($provinces){
                    $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                    $q->whereIn('users.id_provinsi', $provinces);
                });
                break;
            default:

                break;
        }
        if ($this->company_category == CATEGORY_COMPANY){
            $model->with([CATEGORY_COMPANY.'.company_status' => function($q){
                $q->whereYear('created_at', $this->periode);
            }])->whereHas(CATEGORY_COMPANY.'.company_status', function($q){
                $q->whereIn('companies_status.status', [$this->status])->whereYear('companies_status.created_at', $this->periode);
            });
            $model->whereIn('surveys.status', ['verified'])
                ->whereYear('surveys.created_at', $this->periode);
        }else{
            $model->whereHas("{$this->company_category}")->whereIn('surveys.status', [$this->status])
                ->whereYear('surveys.created_at', $this->periode);
        }
        switch ($this->trash){
            case 'not-trash':
                $model->withoutTrashed();
                break;
            case 'trash':
                $model->onlyTrashed();
                break;
            default:
                $model->withTrashed();
                break;
        }
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
            //Button::make('create')->action('window.location.href = "' . route("{$this->identifier}.backend.survey.add", ['company' => $this->company_category]).'"')->text("<i class='fas fa-plus'></i> " . trans("label.add_new_survey_{$this->company_category}")),
            Button::make('export'),
            /*Button::make('print'),*/
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
            ->minifiedAjax('',$script)
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
        $columns = [
            Column::make('no_index', 'no_index')->title('No')
                ->width('1%')->addClass('text-center')
                ->orderable(false)->searchable(false),
            Column::make("{$this->company_category}.name")->title(trans("label.name_{$this->company_category}")),
            Column::make("{$this->company_category}.nib")->title(trans("label.nib_{$this->company_category}")),
            Column::make("{$this->company_category}.provinsi.nama_provinsi")->title(trans('wilayah::label.province')),
            Column::make("{$this->company_category}.name_pic")->title(trans("label.name_pic_of_{$this->company_category}")),
            Column::make('crossMatchingRaw')->title(trans("label.index_{$this->category_reverse}"))->orderable(false)->searchable(false),
            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('auto')
            //->addClass('text-center')
        ];
        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return "cross_matching_{$this->company_category}_" . date('YmdHis');
    }
}
