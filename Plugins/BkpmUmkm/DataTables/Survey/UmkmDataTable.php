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

class UmkmDataTable extends DataTable
{
    protected $dataTableID = 'surveyUmkmDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_UMKM;
    protected $status = 'progress';
    protected $viewed = false;
    protected $periode;
    protected $wilayah_id, $provinsi_id, $status_survey;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();

        $this->inModal = request()->get('in-modal');

        $this->periode = (request()->has('periode') && filter(request()->input('periode')) != '' ? filter(request()->input('periode')) : \Carbon\Carbon::now()->format('Y'));
        $this->wilayah_id = (request()->has('wilayah_id') && filter(request()->input('wilayah_id')) != '' ? filter(request()->input('wilayah_id')) : 'all');
        $this->provinsi_id = (request()->has('provinsi_id') && request()->input('provinsi_id') ? filter(request()->input('provinsi_id')) : ($this->inModal?'all':[]) );
        $this->status_survey = (request()->has('status_survey') && filter(request()->input('status_survey')) != '' ? encrypt_decrypt(filter(request()->input('status_survey')), 1) : 'all');

        $status = request()->get('status');
        if ($this->inModal){
            $this->status = encrypt_decrypt($status, 1);
            $this->dataTableID = "survey_{$this->status}_UmkmDatatable";
            $this->viewed = true;
            $this->show_count = (request()->has('show_count')&&request()->get('show_count'));
            $this->trash = 'not-trash';
        }else{
            if (($key = array_search('all', $this->provinsi_id)) !== false) {
                unset($this->provinsi_id[$key]);
            }
        }
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
            ->editColumn('umkm.name', function($q){
                if ( hasRoute("{$this->identifier}.backend.survey.detail_survey") && hasRoutePermission("{$this->identifier}.backend.survey.detail_survey") && $q->survey_result && !$q->trashed() && !$this->viewed){
                    return '<a href="'. route("{$this->identifier}.backend.survey.detail_survey", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id)]) .'" title="'.trans("label.survey_detail_survey_{$this->company_category}").'">'. $q->umkm->name .'</a>';
                }
                return $q->umkm->name;
            })
            ->editColumn('umkm.bidang_usaha', function($q){ 
                return ($q->umkm->bidang_usaha ? $q->umkm->bidang_usaha : '-');
            })
            ->editColumn('surveyor.name', function($q){
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
            ->editColumn('umkm.provinsi.nama_provinsi', function($q){
                return ($q->umkm->provinsi ? $q->umkm->provinsi->nama_provinsi : '-');
            })
            ->editColumn('umkm.address', function($q){
                return ($q->umkm->address ? nl2br($q->umkm->address) : '-');
            })
            ->editColumn('estimated_date', function ($q){
                return ($q->estimated_date ? Carbon::parse($q->estimated_date)->format('d-m-Y') : '-');
            })
            ->addColumn('periode', function ($q){
                return $q->created_at->format('Y');
            })
            ->addColumn('statusRaw', function ($q){
                $label_status = trans("label.survey_status_{$q->status}");
                switch ($q->status){
                    case 'verified':
                    case 'bersedia':
                        $style_button = 'success';
                        break;
                    case 'done':
                        $style_button = 'info';
                        break;
                    case 'menolak':
                        $style_button = 'danger';
                        break;
                    case 'tutup':
                        $style_button = 'primary';
                        break;
                    case 'pindah':
                        $style_button = 'warning';
                        break;
                    default:
                        $style_button = 'secondary';
                        break;
                }
                $in_status = in_array($q->status, ['progress', 'revision', 'menolak', 'tutup', 'pindah', 'bersedia']);
                $status = '<div class="btn-group-sm">
                                <button type="button" class="btn btn-'.$style_button.' btn-sm '. (!$in_status && enable_periode($q->created_at) ? 'dropdown-toggle" data-toggle="dropdown"' : '"') .'>'. $label_status .'</button>';
                if (hasRoutePermission("{$this->identifier}.backend.survey.change_status") && enable_periode($q->created_at) && !$in_status && !$this->viewed) {
                    $status .= ' <div class="dropdown-menu dropdown-menu-right">
                                    '. ($q->status != 'progress' ? '<a class="dropdown-item eventSurveyChangeStatus text-warning" href="javascript:void(0);" data-selecteddatatable="'.$this->dataTableID.'" data-action="'. route("{$this->identifier}.backend.survey.change_status", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id), 'status' => encrypt_decrypt('progress')]) .'">'. trans("label.survey_status_progress") .'</a>' : '') .'
                                </div>';
                }
                $status .= '</div>';                
                return $status;
            })
            ->editColumn('survey_result.documents', function ($q){
                $html = '';
                switch ($this->user->group_id){
                    case GROUP_SURVEYOR:
                        if ($q->status == 'progress' && hasRoutePermission("{$this->identifier}.backend.survey.download_berita_acara") && enable_periode($q->created_at)){
                            $html .= '<a href="javascript:void(0);" data-action="' . route("{$this->identifier}.backend.survey.download_berita_acara", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id), 'page' => 'modal']) . '" data-method="GET" data-value=\'{}\' class="btn btn-info btn-xs mb-1 show_modal_bs" title="'. trans('label.download') .': ' . trans("label.template_form_survey_{$this->company_category}_berita_acara_survey") .'"><i class="fas fa-download"></i> '. trans('label.download') .': ' . trans("label.template_form_survey_{$this->company_category}_berita_acara_survey") .'</a><br/>';
                        }
                        if ($q->status == 'done' && hasRoutePermission("{$this->identifier}.backend.survey.berita_acara"))
                        {
                            $html .= '<a href="' . route("{$this->identifier}.backend.survey.berita_acara", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id)]) . '" class="btn btn-warning btn-xs mb-1" title="Upload Berita Acara dan Evidance Survey"><i class="fas fa-cloud-upload-alt"></i> Upload Berita Acara dan Evidance Survey</a><br/>';
                        }
                        break;
                }
                if ($q->survey_result && !empty($q->survey_result->documents) && isset($q->survey_result->documents['file'])) {
                    $html .= '<a href="' . asset($q->survey_result->documents['file']) . '" class="btn btn-primary btn-xs mb-1 '. bkpmumkm_colorbox($q->survey_result->documents['file']) .'" title="'. trans('label.photo_scan_berita_acara') .'"><i class="fas fa-file"></i> ' . trans('label.survey_lihat_berita_acara') . '</a><br/>';
                }
                if ($q->survey_result && !empty($q->survey_result->documents) && isset($q->survey_result->documents['photo'])) {
                    $html .= '<a href="javascript:void(0);" class="btn btn-primary show_modal_ex_lg btn-xs mb-1" data-action="'.route("{$this->identifier}.backend.photo.index", ['in-modal' => encrypt_decrypt('modal'), 'survey_id'=>$q->id]).'" data-method="GET" title="'. trans('label.survey_lihat_berita_acara') .'"><i class="fas fa-file-image"></i> ' . 'Foto Evidence Survei' . '</a>';
                }
                return $html;
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group-vertical btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.survey.input_survey") && hasRoutePermission("{$this->identifier}.backend.survey.input_survey") && !in_array($q->status, ['done', 'verified', 'menolak', 'tutup', 'pindah', 'bersedia']) && enable_periode($q->created_at) && !$q->trashed()  && $this->user->group_id == GROUP_SURVEYOR){
                    $html .= '<a class="btn btn-xs btn-primary" href="'. route("{$this->identifier}.backend.survey.input_survey", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id)]) .'" title="'.trans("label.survey_". ($q->survey_result ? 'edit':'input') ."_survey").'"><i class="fas fa-poll"></i> '. trans('label.survey_'. ($q->survey_result ? 'edit':'input') .'_survey') .'</a>';
                }
                if ( hasRoute("{$this->identifier}.backend.survey.verified") && hasRoutePermission("{$this->identifier}.backend.survey.verified") && (in_array($q->status, ['done']) && ($q->survey_result && (isset($q->survey_result->documents['file']) && !empty($q->survey_result->documents['file'])) && (isset($q->survey_result->documents['photo']) && !empty($q->survey_result->documents['photo'])) )) && enable_periode($q->created_at) && !in_array($this->user->group_id, [GROUP_TA]) && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-success" href="'. route("{$this->identifier}.backend.survey.verified", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id)]) .'" title="'. trans("label.survey_verified_{$this->company_category}") .'"><i class="fas fa-check-double"></i> '. trans("label.survey_verified_{$this->company_category}") .'</a>';
                }
                if ( hasRoute("{$this->identifier}.backend.survey.edit") && hasRoutePermission("{$this->identifier}.backend.survey.edit") && enable_periode($q->created_at) && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-warning mt-1" href="'. route("{$this->identifier}.backend.survey.edit", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id)]) .'" title="'.trans("label.edit").'"><i class="fas fa-edit"></i> '. trans('label.edit') .'</a>';
                }
                if ( hasRoute("{$this->identifier}.backend.survey.restore") && hasRoutePermission("{$this->identifier}.backend.survey.restore") && enable_periode($q->created_at) && $q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-info mt-1 eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route("{$this->identifier}.backend.survey.restore", ['company' => $this->company_category]).'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i> '. trans('label.restore') .'</a>';
                }

                if (hasRoutePermission(["{$this->identifier}.backend.survey.soft_delete", "{$this->identifier}.backend.survey.force_delete"]) && enable_periode($q->created_at)) {
                    $html .= '<button type="button" class="btn btn-danger mt-1 dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> '. trans('label.delete') .'</button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute("{$this->identifier}.backend.survey.soft_delete") && hasRoutePermission("{$this->identifier}.backend.survey.soft_delete") && !$q->trashed()) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route("{$this->identifier}.backend.survey.soft_delete", ['company' => $this->company_category]) . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute("{$this->identifier}.backend.survey.force_delete") && hasRoutePermission("{$this->identifier}.backend.survey.force_delete")) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route("{$this->identifier}.backend.survey.force_delete", ['company' => $this->company_category]) . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                if ( hasRoute("{$this->identifier}.backend.survey.activity_log") && hasRoutePermission("{$this->identifier}.backend.survey.activity_log") ){
                    $html .= '<a class="btn btn-xs btn-info mt-1 show_modal_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.survey.activity_log", ['log_name'=>encrypt_decrypt("LOG_SURVEY"), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: ' . $q->{$this->company_category}->name.'"><i class="fas fa-history"></i> '. trans('label.history') .'</a>';
                }

                if ( hasRoute("{$this->identifier}.backend.survey.cetak_pdf") && hasRoutePermission("{$this->identifier}.backend.survey.cetak_pdf") && enable_periode($q->created_at) && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-secondary mt-1" href="'. route("{$this->identifier}.backend.survey.cetak_pdf", ['company' => $this->company_category, 'survey'=>encrypt_decrypt($q->id)]) .'" title="Cetak Profil"><i class="fas fa-print"></i> Cetak Profil</a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['umkm.name', 'survey_result.documents', 'umkm.address', 'surveyor.name', 'statusRaw', 'action'])
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
        $model = $model->select('surveys.*')->with(['umkm', 'umkm.provinsi', 'surveyor', 'survey_result' => function($q){
            $q->select('survey_results.*');
        }]);
        switch ($this->user->group_id){
            case GROUP_SURVEYOR:
                $model->whereHas('umkm')->where('surveys.surveyor_id', $this->user->id);
                break;
            case GROUP_QC_KORPROV:
                $model->whereHas('umkm', function ($q){
                    $q->where('companies.id_provinsi', $this->user->id_provinsi);
                });
                break;
            case GROUP_QC_KORWIL:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);        
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                if ($this->inModal) {
                    if ($this->provinsi_id && $this->provinsi_id !== 'all' && in_array($this->provinsi_id, $provinces)) {
                        $provinces = [$this->provinsi_id];
                    }
                }else {
                    if (count($this->provinsi_id)) {
                        $provinces = $this->provinsi_id;
                    }
                }
                $model->whereHas('umkm', function ($q) use ($provinces) {
                    $q->whereIn('companies.id_provinsi', $provinces);
                });
                break;
            case GROUP_ASS_KORWIL:
            case GROUP_TA:         
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);        
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                if ($this->inModal) {
                    if ($this->provinsi_id && $this->provinsi_id !== 'all' && in_array($this->provinsi_id, $provinces)) {
                        $provinces = [$this->provinsi_id];
                    }
                }else {
                    if (count($this->provinsi_id)) {
                        $provinces = $this->provinsi_id;
                    }
                }
                $model->whereHas('umkm', function ($q) use ($provinces) {
                    $q->whereIn('companies.id_provinsi', $provinces);
                });
                break;
            default:
                if ($this->wilayah_id!=''){
                    $wilayah = simple_cms_setting('bkpmumkm_wilayah');
                    $provinces = [];
                    if($this->wilayah_id!='all'){
                        $provinces = $wilayah[$this->wilayah_id]['provinces'];
                    }
                    if ($this->inModal) {
                        if ($this->provinsi_id&&$this->provinsi_id!=='all'&&in_array($this->provinsi_id, $provinces)){
                            $provinces = [$this->provinsi_id];
                        }
                        if ($this->wilayah_id!='all') {
                            $model->whereHas('umkm', function ($q) use ($provinces) {
                                $q->whereIn('companies.id_provinsi', $provinces);
                            });
                        }else{
                            $model->whereHas('umkm');
                        }
                    }else{
                        if (count($this->provinsi_id)) {
                            $provinces = $this->provinsi_id;
                        }
                        if ($this->wilayah_id=='all'&&count($this->provinsi_id)<=0){
                            $model->whereHas('umkm');
                        }else{
                            $model->whereHas('umkm', function ($q) use($provinces){
                                $q->whereIn('companies.id_provinsi', $provinces);
                            });
                        }
                    }
                }else{
                    $model->whereHas('umkm');
                }
                break;
        }
        if ($this->viewed){
            $model->whereIn('surveys.status', [$this->status]);
        }else {
            $status = ['progress', 'done', 'revision', 'verified', 'menolak', 'tutup', 'pindah', 'bersedia'];
            if ($this->status_survey&&$this->status_survey!='all'&&in_array($this->status_survey, $status)){
                $model->where('surveys.status', $this->status_survey);
            }else {
                $model->whereIn('surveys.status', $status);
            }
        }
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
            Button::make('create')->action('window.location.href = "' . route("{$this->identifier}.backend.survey.add", ['company' => $this->company_category]).'"')->text("<i class='fas fa-plus'></i> " . trans("label.add_new_survey_{$this->company_category}")),
            Button::make('export'),
            /*Button::make('print'),*/
            Button::make('reset'),
            Button::make('reload')
        ];
        if (hasRoutePermission("{$this->identifier}.backend.survey.export")){
            $buttons[1] = Button::make('export')->action('window.location.href = "' . route("{$this->identifier}.backend.survey.export", ['company' => $this->company_category, 'periode' => $this->periode]).'"')->text("<i class='fas fa-file-excel'></i> " . trans("label.export"));
        }
        if ( !hasRoutePermission("{$this->identifier}.backend.survey.add") || $this->viewed ){
            unset($buttons[0]);
        }

        $script = <<<CDATA
                    var formData = $("form#{$this->dataTableID}Form", document).serializeJSON();
                    $.extend( data, formData );
                    /*$.each(formData, function(i, obj){
                        data[obj.name] = obj.value;
                    });*/
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
            Column::make('umkm.bidang_usaha')->title('Bidang Usaha'),
            Column::make('umkm.provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('umkm.address')->title(trans('label.address_umkm')),
            Column::make('estimated_date')->title(trans('label.survey_estimated_date')),
            Column::make('surveyor.name')->title(trans('label.penginput_survey')),
            Column::make('periode')->name('created_at')->title(trans('label.year'))->orderable(false),
            Column::make('statusRaw')->name('statusRaw')->title(trans('label.status'))->printable(false),
            Column::make('survey_result.documents')->title(trans('label.survey_berita_acara')),
            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('auto')
        ];
        if ($this->viewed){
            unset($columns[9]);
            unset($columns[8]);
        }
        if ($this->user->group_id == GROUP_SURVEYOR){
            unset($columns[5]);
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
        return 'umkm_survey_' . date('YmdHis');
    }
}
