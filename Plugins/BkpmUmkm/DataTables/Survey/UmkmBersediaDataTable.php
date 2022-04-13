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

class UmkmBersediaDataTable extends DataTable
{
    protected $dataTableID = 'surveyUmkmBersediaDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_UMKM;
    protected $status = 'bersedia';
    protected $viewed = false;
    protected $periode;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
        $inModal = request()->get('in-modal');
        if ($inModal){
            $this->viewed = true;
            $this->trash = 'not-trash';
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
                if ( hasRoute("{$this->identifier}.backend.verified_bersedia.detail") && hasRoutePermission("{$this->identifier}.backend.verified_bersedia.detail") && $q->survey_result && !$q->trashed() && !$this->viewed ){
                    return '<a href="'. route("{$this->identifier}.backend.verified_bersedia.detail", ['company' => $this->company_category, 'status' => $q->status, 'survey'=>encrypt_decrypt($q->id)]) .'" title="'.trans("label.detail_{$this->company_category}_{$q->status}").'">'. $q->{$this->company_category}->name .'</a>';
                }
                return $q->{$this->company_category}->name;
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
            ->addColumn('statusRaw', function ($q){
                $status = trans("label.survey_status_{$q->status}");
                $style_button = ($q->status == $this->status ? 'success' : ($q->status == 'done' ? 'info' : 'warning'));
                $status = '<div class="btn-group-sm">
                                <button type="button" class="btn btn-'.$style_button.' dropdown-toggle btn-sm" data-toggle="dropdown">'. $status .'</button>';
                if (hasRoutePermission("{$this->identifier}.backend.survey.change_status") && in_array($q->status, [$this->status]) && enable_periode($q->created_at) && !$this->viewed) {
                    $status .= ' <div class="dropdown-menu  dropdown-menu-right">
                                    <a class="dropdown-item eventSurveyChangeStatus text-info" href="javascript:void(0);" data-selecteddatatable="'.$this->dataTableID.'" data-action="'. route("{$this->identifier}.backend.survey.change_status", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id), 'status' => encrypt_decrypt('verified')]) .'">'. trans("label.survey_status_tidak_bersedia") .'</a>
                                </div>';
                }
                $status .= '</div>';
                return $status;
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group-vertical btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.survey.activity_log") && hasRoutePermission("{$this->identifier}.backend.survey.activity_log") ){
                    $html .= '<a class="btn btn-xs btn-info mt-1 show_modal_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.survey.activity_log", ['log_name'=>encrypt_decrypt("LOG_SURVEY"), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: ' . $q->{$this->company_category}->name.'"><i class="fas fa-history"></i> '. trans('label.history') .'</a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(["{$this->company_category}.name", 'survey_result.documents', "{$this->company_category}.name_pic", "{$this->company_category}.address", 'statusRaw', 'action'])
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
        $model = $model->whereHas("{$this->company_category}")->with(["{$this->company_category}", "{$this->company_category}.pic", "{$this->company_category}.provinsi", 'surveyor', 'survey_result']);
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
            Button::make('export'),            
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
                
            Column::make('umkm.name')->title(trans('label.name_umkm')),
            Column::make("{$this->company_category}.nib")->title(trans("label.nib_{$this->company_category}")),
            Column::make('umkm.provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('umkm.address')->title(trans('label.address_umkm')),
            Column::make("{$this->company_category}.name_pic")->title(trans("label.name_pic_of_{$this->company_category}")),
            Column::make('statusRaw')->name('status')->title(trans('label.status'))->printable(false),

            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('auto')
        ];
        
        if ($this->viewed){
            unset($columns[7]);
        }
        if ($this->user->group_id == GROUP_SURVEYOR){
            unset($columns[4]);
        }
        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'umkm_bersedia_' . date('YmdHis');
    }
}
