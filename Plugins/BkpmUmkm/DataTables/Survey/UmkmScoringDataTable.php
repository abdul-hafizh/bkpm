<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Survey;

use Illuminate\Support\Carbon;
use Plugins\BkpmUmkm\Models\SurveyModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UmkmScoringDataTable extends DataTable
{
    protected $dataTableID = 'surveyUmkmScoringDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_UMKM;
    protected $status = 'verified';
    protected $periode;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
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
                return $q->{$this->company_category}->name;
            })
            ->editColumn("{$this->company_category}.nib", function($q){
                return ($q->{$this->company_category}->nib ? $q->{$this->company_category}->nib : '-');
            })
            /*->editColumn('surveyor.name', function($q){
                if ($q->surveyor) {
                    $html = '<div class="user-block">
                          <span class="username ml-1"><a>' . $q->surveyor->name . '</a></span>';
                    $html .= '<span class="description ml-1">';
                    if (!empty($q->surveyor->email)) {
                        $html .= '<i class="fas fa-envelope"></i> ' . $q->surveyor->email;
                    }
                    if (!empty($q->surveyor->mobile_phone)) {
                        $html .= '<br/><i class="fas fa-phone"></i> ' . $q->surveyor->mobile_phone;
                    }
                    $html .= '</span>';
                    $html .= '</div>';
                    return $html;
                }
                return '-';
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
            })*/
            ->editColumn("{$this->company_category}.provinsi.nama_provinsi", function($q){
                return ($q->{$this->company_category}->provinsi ? $q->{$this->company_category}->provinsi->nama_provinsi : '-');
            })
            ->editColumn("{$this->company_category}.kabupaten.nama_kabupaten", function($q){
                return ($q->{$this->company_category}->kabupaten ? $q->{$this->company_category}->kabupaten->nama_kabupaten : '-');
            })
            ->addColumn('kbli_name_raw', function($q){
                if ($q->{$this->company_category}->kbli){
                    $html = "<ul class='table-ul'>";
                    foreach ($q->{$this->company_category}->kbli as $kbli) {
                        $html .= "<li>[{$kbli->code}] {$kbli->name}</li>";
                    }
                    $html .= "</ul>";
                    return $html;
                }
                return '-';
            })
            ->editColumn("{$this->company_category}.sector.name", function($q){
                return ($q->{$this->company_category}->sector ? $q->{$this->company_category}->sector->name : '-');
            })
            /*->editColumn("{$this->company_category}.address", function($q){
                return ($q->{$this->company_category}->address ? nl2br($q->{$this->company_category}->address) : '-');
            })*/
            ->addColumn('scoringRaw', function($q){
                $class = 'danger';
                if ($q->scoring > 0 && $q->scoring <= 50){
                    $class = 'warning';
                }elseif($q->scoring > 50){
                    $class = 'success';
                }
                if (hasRoutePermission("{$this->identifier}.backend.umkm.survey.scoring.save_update") && enable_periode($q->created_at)) {
                    $html = '<a href="javascript:void(0);" class="btn btn-xs btn-block btn-'. $class .' show_modal_bs" data-action="' . route("{$this->identifier}.backend.umkm.survey.scoring.save_update", ['survey' => encrypt_decrypt($q->id), 'in_modal' => encrypt_decrypt(\Str::random(5))]) . '" data-title="' . trans('label.scoring') . ': ' . $q->{$this->company_category}->name . '" title="Input score">' . $q->scoring . '</a>';
                }else {
                    $html = '<a href="javascript:void(0);" class="btn btn-xs btn-block btn-' . $class . '">' . $q->scoring . '</a>';
                }
                if ( hasRoute("{$this->identifier}.backend.umkm.survey.scoring.activity_log") && hasRoutePermission("{$this->identifier}.backend.umkm.survey.scoring.activity_log") ){
                    $html .= '<a class="btn btn-xs btn-info mt-1 show_modal_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.umkm.survey.scoring.activity_log", ['log_name'=>encrypt_decrypt("LOG_SURVEY_SCORING"), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: ' . $q->{$this->company_category}->name.'"><i class="fas fa-history"></i> '. trans('label.history') .'</a>';
                }
                return $html;
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group-vertical btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.umkm.survey.scoring.activity_log") && hasRoutePermission("{$this->identifier}.backend.umkm.survey.scoring.activity_log") ){
                    $html .= '<a class="btn btn-xs btn-info mt-1 show_modal_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.umkm.survey.scoring.activity_log", ['log_name'=>encrypt_decrypt("LOG_SURVEY_SCORING"), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: ' . $q->{$this->company_category}->name.'"><i class="fas fa-history"></i> '. trans('label.history') .'</a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(["{$this->company_category}.name", "scoringRaw", 'kbli_name_raw', "{$this->company_category}.sector.name", 'action'])
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
        $model = $model->whereHas("{$this->company_category}")->with(["{$this->company_category}", "{$this->company_category}.kbli", "{$this->company_category}.sector", "{$this->company_category}.provinsi", "{$this->company_category}.kabupaten",]);
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
        $model->whereIn('surveys.status', [$this->status]);
        $model->whereYear('surveys.created_at', $this->periode);
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
            Column::make('umkm.provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('umkm.kabupaten.nama_kabupaten')->title(trans('wilayah::label.kabupaten')),
            Column::make("{$this->company_category}.sector.name")->title(trans("label.sector_{$this->company_category}")),
            Column::make('kbli_name_raw')->name('kbli.name')->title(trans('label.kbli'))->orderable(false)->searchable(false),
            Column::make('scoringRaw')->name('scoring')->title(trans('label.scoring'))->addClass('text-right')->exportable(false)->printable(false),
            Column::make('scoring')->title(trans('label.scoring'))->visible(false)
            /*Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('auto')*/
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
        return 'umkm_scoring_' . date('YmdHis');
    }
}
