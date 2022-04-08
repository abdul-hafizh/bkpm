<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Umkm;

use Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SurveyUmkmObservasiMassiveDataTable extends DataTable
{
    protected $dataTableID = 'surveyUmkmObservasiMassiveDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $viewed = false;
    protected $periode, $wilayah_id, $provinsi_id;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();

        $this->periode = (request()->has('periode') && filter(request()->input('periode')) != '' ? filter(request()->input('periode')) : \Carbon\Carbon::now()->format('Y'));
        $this->wilayah_id = (request()->has('wilayah_id') && filter(request()->input('wilayah_id')) != '' ? filter(request()->input('wilayah_id')) : 'all');
        $this->provinsi_id = (request()->has('provinsi_id') && filter(request()->input('provinsi_id')) != '' ? filter(request()->input('provinsi_id')) : 'all');
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
            ->of($query)
            ->editColumn('name_umkm_raw', function($q){
                $name_umkm = $q->name_umkm;//($q->umkm ? $q->umkm->name : $q->name_umkm);
                $html = '<div class="user-block">
                          <span class="username ml-1">';
                if (hasRoutePermission("{$this->identifier}.backend.umkm.survey_massive.detail") && !$q->trashed()){
                    $html .= '<a href="javascript:void(0);" data-action="'. route("{$this->identifier}.backend.umkm.survey_massive.detail", ['id' => encrypt_decrypt($q->id)]) .'" data-method="GET" data-value="" class="show_modal_ex_lg" title="'. $name_umkm .'">' . $name_umkm . '</a>';
                }else{
                    $html .= '<a>'. $name_umkm .'</a>';
                }
                $html .='</span>';
                $html .= '<span class="description ml-1">';
                if (!empty($q->name_director)){
                    $html .= '<i class="fas fa-user"></i> ' . $q->name_director;
                }
                if (!empty($q->phone_director)){
                    $html .= '<br/><i class="fas fa-phone"></i> ' . $q->phone_director;
                }
                $html .= '</span>';
                $html .= '</div>';
                return $html;
            })
            ->editColumn('nama_surveyor_raw', function($q){
                $html = '<div class="user-block">
                          <span class="username ml-1"><a>'. $q->nama_surveyor .'</a></span>';
                $html .= '<span class="description ml-1">';
                if (!empty($q->phone_surveyor)){
                    $html .= '<i class="fas fa-phone"></i> ' . $q->phone_surveyor;
                }
                $html .= '</span>';
                $html .= '</div>';
                return $html;
            })
            ->editColumn('nama_provinsi', function($q){
                return $q->nama_provinsi;//($q->umkm->provinsi ? $q->umkm->provinsi->nama_provinsi : '-');
            })
            ->editColumn('nama_kabupaten', function($q){
                return $q->nama_kabupaten;//($q->umkm->kabupaten ? $q->umkm->kabupaten->nama_kabupaten : '-');
            })
            ->editColumn('created_at', function ($q){
                return ($q->created_at ? carbonParseTransFormat($q->created_at, 'l, d F Y') : '-');
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.umkm.survey_massive.edit") && hasRoutePermission("{$this->identifier}.backend.umkm.survey_massive.edit") && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-warning" href="'. route("{$this->identifier}.backend.umkm.survey_massive.edit", ['id'=>encrypt_decrypt($q->id)]) .'" title="'.trans('label.edit_umkm').'"><i class="fas fa-edit"></i></a>';
                }
                if ( hasRoute("{$this->identifier}.backend.umkm.survey_massive.restore") && hasRoutePermission("{$this->identifier}.backend.umkm.survey_massive.restore") && $q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route("{$this->identifier}.backend.umkm.survey_massive.restore").'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i></a>';
                }

                if (hasRoutePermission(["{$this->identifier}.backend.umkm.survey_massive.soft_delete", "{$this->identifier}.backend.umkm.survey_massive.force_delete"])) {
                    $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute("{$this->identifier}.backend.umkm.survey_massive.soft_delete") && hasRoutePermission("{$this->identifier}.backend.umkm.survey_massive.soft_delete") && !$q->trashed()) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route("{$this->identifier}.backend.umkm.survey_massive.soft_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute("{$this->identifier}.backend.umkm.survey_massive.force_delete") && hasRoutePermission("{$this->identifier}.backend.umkm.survey_massive.force_delete")) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route("{$this->identifier}.backend.umkm.survey_massive.force_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                if ( hasRoute("{$this->identifier}.backend.umkm.survey_massive.activity_log") && hasRoutePermission("{$this->identifier}.backend.umkm.survey_massive.activity_log") ){
                    $html .= '<a class="btn btn-xs btn-info show_modal_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.umkm.survey_massive.activity_log", ['log_name'=>encrypt_decrypt("LOG_SURVEY_UMKM_MASSIVE"), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: '.$q->name_umkm.'"><i class="fas fa-history"></i></a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['name_umkm_raw', 'nama_surveyor_raw', 'action'])
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SurveyUmkmMassiveModel $model)
    {
        $model = $model->with(['umkm'])->whereYear('created_at', $this->periode);
        /*switch ($this->user->group_id){
            case GROUP_QC_KORPROV:
                $model->where('id_provinsi_umkm', $this->user->id_provinsi);
                break;
            case GROUP_SURVEYOR:
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                $model->whereIn('id_provinsi_umkm', $provinces);
                break;
            default:

                break;
        }*/
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
            Button::make('create')->action('window.location.href = "' . route("{$this->identifier}.backend.umkm.survey_massive.add").'"'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( !hasRoutePermission("{$this->identifier}.backend.umkm.survey_massive.add") || $this->viewed ){
            unset($buttons[0]);
        }

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
            Column::make('name_umkm_raw')->name('name_umkm')->title(trans('label.name_umkm'))->exportable(false)->printable(false),
            Column::make('name_umkm')->title(trans('label.name_umkm'))->visible(false),
            Column::make('nib_umkm')->title(trans('label.nib_umkm')),
            Column::make('desc_kbli_umkm')->title('Desc KBLI')->visible(false),
            Column::make('nama_provinsi_umkm')->title('Provinsi UMKM'),
            Column::make('nama_kabupaten_umkm')->title('Kabupaten UMKM')->visible(false),
            Column::make('nama_kabupaten_umkm')->title('Kabupaten UMKM')->visible(false),
            Column::make('address_umkm')->title('Alamat UMKM')->visible(false),
            Column::make('name_director_umkm')->title('Pemilik')->visible(false),
            Column::make('phone_director_umkm')->title('No Telp Pemilik')->visible(false),
            Column::make('nama_surveyor_raw')->name('nama_surveyor')->title('Surveyor')->exportable(false)->printable(false),
            Column::make('nama_surveyor')->title('Surveyor')->visible(false),
            Column::make('phone_surveyor')->title('Telp Surveyor')->visible(false),
            Column::make('nama_provinsi_surveyor')->title('Provinsi Surveyor')->visible(false),
            Column::make('nama_kabupaten_surveyor')->title('Kabupaten Surveyor')->visible(false),
            Column::make('address_surveyor')->title('Alamat Surveyor')->visible(false),
            Column::make('created_at')->title(trans('label.date_survey')),
            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('5%')
                ->addClass('text-center'),
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
        return 'survey_umkm_observasi_massive_' . date('YmdHis');
    }
}
