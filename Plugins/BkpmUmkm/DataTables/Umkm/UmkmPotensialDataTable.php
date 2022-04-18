<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Umkm;

use Plugins\BkpmUmkm\Models\CompanyModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UmkmPotensialDataTable extends DataTable
{
    protected $dataTableID = 'umkmDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_UMKM;
    protected $viewed = false;
    protected $belum_disurvey = false;
    protected $periode, $wilayah_id, $provinsi_id, $sektor_id;
    protected $has_not_nib='';

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
        $inModal = request()->get('in-modal');
        $status = encrypt_decrypt(request()->get('status'), 2);
        if ($inModal){
            $this->viewed = true;
        }
        if ($status == 'belum_disurvey'){
            $this->belum_disurvey = true;
        }
        $this->periode = (request()->has('periode') && filter(request()->input('periode')) != '' ? filter(request()->input('periode')) : \Carbon\Carbon::now()->format('Y'));
        $this->has_not_nib = (request()->has('nib') && filter(request()->input('nib')) != '' ? filter(request()->input('nib')) : '');
        $this->wilayah_id = (request()->has('wilayah_id') && filter(request()->input('wilayah_id')) != '' ? filter(request()->input('wilayah_id')) : 'all');
        $this->provinsi_id = (request()->has('provinsi_id') && filter(request()->input('provinsi_id')) != '' ? filter(request()->input('provinsi_id')) : 'all');
        $this->sektor_id = (request()->has('sektor_id') && filter(request()->input('sektor_id')) != '' ? filter(request()->input('sektor_id')) : 'all');
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
            ->editColumn('name_raw', function($q){
                if (hasRoutePermission("{$this->identifier}.backend.umkm.potensial.detail") && !$this->viewed){
                    return '<a href="'. route("{$this->identifier}.backend.umkm.potensial.detail", ['id' => encrypt_decrypt($q->id)]) .'" title="'. $q->name .'">' . $q->name . '</a>';
                }
                return $q->name;
            })
            ->editColumn('name_director_raw', function($q){
                $html = '<div class="user-block">
                          <span class="username ml-1"><a>'. $q->name_director .'</a></span>';
                $html .= '<span class="description ml-1">';
                if (!empty($q->email_director)){
                    $html .= '<i class="fas fa-envelope"></i> ' . $q->email_director;
                }
                if (!empty($q->phone_director)){
                    $html .= '<br/><i class="fas fa-phone"></i> ' . $q->phone_director;
                }
                $html .= '</span>';
                $html .= '</div>';
                return $html;
            })
            ->editColumn('name_pic_raw', function($q){
                $html = '<div class="user-block">
                          <span class="username ml-1"><a>'. $q->name_pic .'</a></span>';
                $html .= '<span class="description ml-1">';
                if (!empty($q->email_pic)){
                    $html .= '<i class="fas fa-envelope"></i> ' . $q->email_pic;
                }
                if (!empty($q->phone_pic)){
                    $html .= '<br/><i class="fas fa-phone"></i> ' . $q->phone_pic;
                }
                $html .= '</span>';
                $html .= '</div>';
                return $html;
            })
            ->editColumn('negara.nama_negara', function($q){
                return ($q->negara ? $q->negara->nama_negara : '-');
            })
            ->editColumn('provinsi.nama_provinsi', function($q){
                return ($q->provinsi ? $q->provinsi->nama_provinsi : '-');
            })
            ->editColumn('kabupaten.nama_kabupaten', function($q){
                return ($q->kabupaten ? $q->kabupaten->nama_kabupaten : '-');
            })
            ->editColumn('sector.name', function($q){
                return ($q->sector ? $q->sector->name : '-');
            })
            ->addColumn('kbli_name_raw', function($q){
                if ($q->kbli){
                    $html = "<ul class='table-ul'>";
                    foreach ($q->kbli as $kbli) {
                        $html .= "<li>[{$kbli->code}] {$kbli->name}</li>";
                    }
                    $html .= "</ul>";
                    return $html;
                }else{
                    $q->sync_kbli_single_to_multiple();
                }
                return '-';
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.umkm.potensial.edit") && hasRoutePermission("{$this->identifier}.backend.umkm.potensial.edit") && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-warning" href="'. route("{$this->identifier}.backend.umkm.potensial.edit", ['id'=>encrypt_decrypt($q->id)]) .'" title="'.trans('label.edit_umkm').'"><i class="fas fa-edit"></i></a>';
                }
                if ( hasRoute("{$this->identifier}.backend.umkm.potensial.restore") && hasRoutePermission("{$this->identifier}.backend.umkm.potensial.restore") && $q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route("{$this->identifier}.backend.umkm.potensial.restore").'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i></a>';
                }

                if (hasRoutePermission(["{$this->identifier}.backend.umkm.potensial.soft_delete", "{$this->identifier}.backend.umkm.potensial.force_delete"])) {
                    $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute("{$this->identifier}.backend.umkm.potensial.soft_delete") && hasRoutePermission("{$this->identifier}.backend.umkm.potensial.soft_delete") && !$q->trashed()) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route("{$this->identifier}.backend.umkm.potensial.soft_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute("{$this->identifier}.backend.umkm.potensial.force_delete") && hasRoutePermission("{$this->identifier}.backend.umkm.potensial.force_delete")) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route("{$this->identifier}.backend.umkm.potensial.force_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                if ( hasRoute("{$this->identifier}.backend.umkm.potensial.activity_log") && hasRoutePermission("{$this->identifier}.backend.umkm.potensial.activity_log") ){
                    $html .= '<a class="btn btn-xs btn-info show_modal_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.umkm.potensial.activity_log", ['log_name'=>encrypt_decrypt("LOG_UMKM"), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: '.$q->name.'"><i class="fas fa-history"></i></a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['name_raw', 'name_director_raw', 'name_pic_raw', 'kbli_name_raw', 'action'])
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Plugins\BkpmUmkm\Models\CompanyModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CompanyModel $model)
    {
        $model = $model->where('companies.category', $this->company_category)->with(['sector', 'kbli', 'pic', 'negara', 'provinsi', 'kabupaten'])->where('companies.status', UMKM_POTENSIAL);
        switch ($this->user->group_id){
            case GROUP_QC_KORPROV:
                $model->where('companies.id_provinsi', $this->user->id_provinsi);
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                if ($this->provinsi_id&&$this->provinsi_id!=='all'&&in_array($this->provinsi_id, $provinces)){
                    $provinces = [$this->provinsi_id];
                }if ($this->provinsi_id_select&&$this->provinsi_id_select!=='all'&&in_array($this->provinsi_id_select, $provinces)){
                    $provinces = [$this->provinsi_id_select];
                }
                $model->whereIn('companies.id_provinsi', $provinces);
                break;
            default:
                if ($this->wilayah_id!='') {
                    $wilayah = simple_cms_setting('bkpmumkm_wilayah');
                    $provinces = [];
                    if($this->wilayah_id!='all') {
                        $provinces = $wilayah[$this->wilayah_id]['provinces'];
                    }
                    if ($this->provinsi_id && $this->provinsi_id !== 'all' && in_array($this->provinsi_id, $provinces)) {
                        $provinces = [$this->provinsi_id];
                    }if ($this->provinsi_id_select && $this->provinsi_id_select !== 'all' && in_array($this->provinsi_id_select, $provinces)) {
                        $provinces = [$this->provinsi_id_select];
                    }elseif ($this->provinsi_id == 'all' && $this->wilayah_id=='all'){
                        foreach (list_bkpmumkm_wilayah_by_user() as $wilayah1) {
                            if (count($wilayah1['provinces'])){
                                foreach ($wilayah1['provinces'] as $province) {
                                    $provinces[] = $province['kode_provinsi'];
                                }
                            }
                        }
                    }
                    $model->whereIn('companies.id_provinsi', $provinces);
                }
                break;
        }
        if ($this->belum_disurvey){
            $model->whereRaw("companies.id NOT IN (select surveys.company_id FROM surveys where surveys.status in ('done','progress','revision','verified', 'bersedia', 'menolak', 'tutup', 'pindah'))");
        }        
        
        $model->whereHas('survey', function ($q){
            $q->whereYear('surveys.created_at', $this->periode);
        });
        
        if (!empty($this->has_not_nib)){
            switch ($this->has_not_nib){
                case 'has':
                    $model->where('companies.nib', '<>', '');
                    break;
                case 'not':
                    $model->where('companies.nib', '=', '');
                    break;
            }
        }

        if (!empty($this->sektor_id != 'all')){
            $model->where('companies.business_sector_id', '=', $this->sektor_id);
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
            Button::make('create')->action('window.location.href = "' . route("{$this->identifier}.backend.umkm.potensial.add").'"'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( !hasRoutePermission("{$this->identifier}.backend.umkm.potensial.add") || $this->viewed ){
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
            Column::make('name_raw')->name('name')->title(trans('label.name_umkm'))->exportable(false)->printable(false),
            Column::make('name')->title(trans('label.name_umkm'))->visible(false),
            Column::make('nib')->title(trans('label.nib_umkm')),
            Column::make('sector.name')->title(trans('label.sector_umkm')),
            Column::make('kbli_name_raw')->name('kbli.name')->title(trans('label.kbli'))->orderable(false)->searchable(false),
            Column::make('negara.nama_negara')->title(trans('wilayah::label.country'))->visible(false),
            Column::make('provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('kabupaten.nama_kabupaten')->title(trans('wilayah::label.kabupaten'))->visible(false),
            Column::make('address')->title('Alamat')->visible(false),
            Column::make('name_director_raw')->name('name_director')->title(trans('label.name_director_of_umkm'))->exportable(false)->printable(false),
            Column::make('name_director')->title(trans('label.name_director_of_umkm'))->visible(false),
            Column::make('email_director')->visible(false),
            Column::make('phone_director')->visible(false),
            Column::make('name_pic_raw')->name('name_pic')->title(trans('label.name_pic_of_umkm'))->exportable(false)->printable(false),
            Column::make('name_pic')->title(trans('label.name_pic_of_umkm'))->visible(false),
            Column::make('email_pic')->visible(false),
            Column::make('phone_pic')->visible(false),
            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('5%')
                ->addClass('text-center'),
        ];
        if ($this->viewed){
            unset($columns[18]);
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
        return 'umkm_potensial_' . date('YmdHis');
    }
}
