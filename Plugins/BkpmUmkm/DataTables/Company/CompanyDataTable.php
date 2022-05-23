<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Company;

use Plugins\BkpmUmkm\Models\CompanyModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompanyDataTable extends DataTable
{
    protected $dataTableID = 'companyDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $status;
    protected $flag_respon='';
    protected $flag_zoom='';
    protected $status_filter='';
    protected $company_category = CATEGORY_COMPANY;
    protected $viewed = false;
    protected $periode, $wilayah_id, $provinsi_id;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
        $inModal = request()->get('in-modal');
        if ($inModal){
            $this->viewed = true;
        }
        $this->periode = (request()->has('periode') && filter(request()->input('periode')) != '' ? filter(request()->input('periode')) : \Carbon\Carbon::now()->format('Y'));
        $this->status = (request()->has('status') && filter(request()->input('status')) != '' ? filter(request()->input('status')) : 'all');
        $this->wilayah_id = (request()->has('wilayah_id') && filter(request()->input('wilayah_id')) != '' ? filter(request()->input('wilayah_id')) : 'all');
        $this->provinsi_id = (request()->has('provinsi_id') && filter(request()->input('provinsi_id')) != '' ? filter(request()->input('provinsi_id')) : 'all');
        $this->flag_respon = (request()->has('flag_respon') && filter(request()->input('flag_respon')) != '' ? filter(request()->input('flag_respon')) : '');
        $this->flag_zoom = (request()->has('flag_zoom') && filter(request()->input('flag_zoom')) != '' ? filter(request()->input('flag_zoom')) : '');
        $this->status_filter = (request()->has('status_filter') && filter(request()->input('status_filter')) != '' ? filter(request()->input('status_filter')) : '');
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
            ->editColumn('name', function($q){
                if (hasRoutePermission("{$this->identifier}.backend.company.detail") && !$this->viewed){
                    return '<a href="'. route("{$this->identifier}.backend.company.detail", ['id' => encrypt_decrypt($q->id)]) .'" title="'. $q->name .'">' . $q->name . '</a>';
                }
                return $q->name;
            })
            ->editColumn('name_director', function($q){
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
            ->editColumn('name_pic', function($q){
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
            ->addColumn('company_status.statusRaw', function ($q) {
                /* Bersedia, Tidak Bersedia, Tidak Respon, Konsultasi BKPM, Menunggu Konfirmasi */
                $status = ($q->company_status && $q->company_status->status  ? trans("label.company_status_{$q->company_status->status}") : '--------');
                $color = 'secondary';
                if ($q->company_status){
                    switch ($q->company_status->status) {
                        case 'bersedia':
                            $color = 'success';
                            break;
                        case 'tidak_bersedia':
                            $color = 'danger';
                            break;
                        case 'tidak_respon':
                            $color = 'warning';
                            break;
                        case 'konsultasi_bkpm':
                            $color = 'primary';
                            break;
                        case 'menunggu_konfirmasi':
                            $color = 'info';
                            break;
                    }
                }

                $status = '<div class="btn-group-sm">
                                <button type="button" class="btn btn-'.$color.' dropdown-toggle btn-sm" data-toggle="dropdown">'. $status .'</button>';
                if (hasRoutePermission("{$this->identifier}.backend.company.change_status") && enable_periode($q->company_status->created_at) && !$this->viewed) {
                    $status .= '<div class="dropdown-menu  dropdown-menu-right">';
                    $status .= '<a class="dropdown-item eventCompanyChangeStatus text-success" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('bersedia'), 'label_status' => trans("label.company_status_bersedia"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_bersedia") . '</a>';
                    $status .= '<a class="dropdown-item eventCompanyChangeStatus text-danger" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('tidak_bersedia'), 'label_status' => trans("label.company_status_tidak_bersedia"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_tidak_bersedia") . '</a>';
                    $status .= '<a class="dropdown-item eventCompanyChangeStatus text-warning" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('tidak_respon'), 'label_status' => trans("label.company_status_tidak_respon"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_tidak_respon") . '</a>';
                    $status .= '<a class="dropdown-item eventCompanyChangeStatus text-primary" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('konsultasi_bkpm'), 'label_status' => trans("label.company_status_konsultasi_bkpm"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_konsultasi_bkpm") . '</a>';
                    $status .= '<a class="dropdown-item eventCompanyChangeStatus text-info" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('menunggu_konfirmasi'), 'label_status' => trans("label.company_status_menunggu_konfirmasi"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_menunggu_konfirmasi") . '</a>';
                    $status .= '</div>';
                }
                $status .= '</div>';
                return $status;
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.company.edit") && hasRoutePermission("{$this->identifier}.backend.company.edit") && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-warning" href="'. route("{$this->identifier}.backend.company.edit", ['id'=>encrypt_decrypt($q->id)]) .'" title="'.trans('label.edit_company').'"><i class="fas fa-edit"></i></a>';
                }
                if ( hasRoute("{$this->identifier}.backend.company.restore") && hasRoutePermission("{$this->identifier}.backend.company.restore") && enable_periode($q->company_status->created_at) && $q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route("{$this->identifier}.backend.company.restore").'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i></a>';
                }

                if (hasRoutePermission(["{$this->identifier}.backend.company.soft_delete", "{$this->identifier}.backend.company.force_delete"]) && enable_periode($q->company_status->created_at)) {
                    $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute("{$this->identifier}.backend.company.soft_delete") && hasRoutePermission("{$this->identifier}.backend.company.soft_delete") && !$q->trashed()) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route("{$this->identifier}.backend.company.soft_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute("{$this->identifier}.backend.company.force_delete") && hasRoutePermission("{$this->identifier}.backend.company.force_delete")) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route("{$this->identifier}.backend.company.force_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                if ( hasRoute("{$this->identifier}.backend.company.activity_log") && hasRoutePermission("{$this->identifier}.backend.company.activity_log") ){
                    $html .= '<a class="btn btn-xs btn-info show_modal_ex_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.company.activity_log", ['log_name'=>encrypt_decrypt("LOG_COMPANY"), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: '.$q->name.'"><i class="fas fa-history"></i></a>';
                }                
                
                $html .= '<a class="btn btn-xs btn-success show_modal_ex_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.journal.index", ['in-modal' => encrypt_decrypt('modal'), 'company_id'=>$q->id]).'" data-method="GET" title="Journal: '.$q->name.'"><i class="fas fa-book-open"></i></a>';                

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['name', 'name_director', 'name_pic', 'company_status.statusRaw', 'kbli_name_raw', 'action'])
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
        $model = $model->where('category', $this->company_category)->with(['sector', 'kbli', 'pic', 'negara', 'provinsi', 'company_status'=>function($q){
            $q->whereYear('created_at', $this->periode);
        }])->whereHas('company_status', function($q){
            $q->whereYear('companies_status.created_at', $this->periode);
            if ($this->status !== 'all'){
                if($this->status == 'not_set') {
                    $q->where(function ($q) {
                        $q->whereNull('companies_status.status')->orWhere('companies_status.status', '');
                    });
                }else {
                    $q->where('companies_status.status', $this->status);
                }
            }
        });
        switch ($this->user->group_id){
            case GROUP_QC_KORPROV:
            case GROUP_SURVEYOR:
                $model->where('companies.id_provinsi', $this->user->id_provinsi);
                if (!empty($this->flag_respon)){
                    switch ($this->flag_respon){
                        case 'respon':
                            $model->whereIn('companies.flag_respon', [1,2,3]);
                            break;
                        case 'respon1':
                            $model->where('companies.flag_respon', 1);
                            break;
                        case 'respon2':
                            $model->where('companies.flag_respon', 2);
                            break;
                        case 'respon3':
                            $model->where('companies.flag_respon', 3);
                            break;
                    }
                }
        
                if (!empty($this->flag_zoom)){
                    switch ($this->flag_zoom){
                        case 'blmJadwal':
                            $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', '=', NULL);
                            break;
                        case 'online':
                            $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', 1);
                            break;
                        case 'offline':
                            $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', 2);
                            break;
                    }
                }
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:                
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                if ($this->provinsi_id&&$this->provinsi_id!=='all'&&in_array($this->provinsi_id, $provinces)){
                    $provinces = [$this->provinsi_id];
                }
                $model->whereIn('companies.id_provinsi', $provinces);
                if (!empty($this->flag_respon)){
                    switch ($this->flag_respon){
                        case 'respon':
                            $model->whereIn('companies.flag_respon', [1,2,3]);
                            break;
                        case 'respon1':
                            $model->where('companies.flag_respon', 1);
                            break;
                        case 'respon2':
                            $model->where('companies.flag_respon', 2);
                            break;
                        case 'respon3':
                            $model->where('companies.flag_respon', 3);
                            break;
                    }
                }
        
                if (!empty($this->flag_zoom)){
                    switch ($this->flag_zoom){
                        case 'blmJadwal':
                            $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', '=', NULL);
                            break;
                        case 'online':
                            $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', 1);
                            break;
                        case 'offline':
                            $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', 2);
                            break;
                    }
                }
                break;
            default:
                if ($this->wilayah_id!='') {
                    $wilayah = simple_cms_setting('bkpmumkm_wilayah');
                    $provinces = [];
                    if($this->wilayah_id!='all') {
                        $provinces = $wilayah[$this->wilayah_id]['provinces'];
                    }
                    if ($this->provinsi_id && $this->provinsi_id !== 'all'&&in_array($this->provinsi_id, $provinces)) {
                        $provinces = [$this->provinsi_id];
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
                    if (!empty($this->flag_respon)){
                        switch ($this->flag_respon){
                            case 'respon':
                                $model->whereIn('companies.flag_respon', [1,2,3]);
                                break;
                            case 'respon1':
                                $model->where('companies.flag_respon', 1);
                                break;
                            case 'respon2':
                                $model->where('companies.flag_respon', 2);
                                break;
                            case 'respon3':
                                $model->where('companies.flag_respon', 3);
                                break;
                        }
                    }
            
                    if (!empty($this->flag_zoom)){
                        switch ($this->flag_zoom){
                            case 'blmJadwal':
                                $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', '=', NULL);
                                break;
                            case 'online':
                                $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', 1);                                
                                break;
                            case 'offline':
                                $model->where('companies.flag_respon', 1)->where('companies.flag_zoom', 2);
                                break;
                        }
                    }                    
                }
                break;
        }               
        
        if (!empty($this->status_filter)){
            $model->whereHas('companies_status', function ($q){                
                switch ($this->status_filter){
                    case 'bersedia':
                        $q->where('companies_status.status', 'bersedia');
                        break;
                    case 'tidak_bersedia':
                        $q->where('companies_status.status', 'tidak_bersedia');
                        break;
                    case 'tidak_respon':
                        $q->where('companies_status.status', 'tidak_respon');
                        break;
                    case 'konsultasi_bkpm':
                        $q->where('companies_status.status', 'konsultasi_bkpm');
                        break;
                    case 'menunggu_konfirmasi':
                        $q->where('companies_status.status', 'menunggu_konfirmasi');
                        break;
                    case 'belum_terisi':
                        $q->where('companies_status.status', NULL);
                        break;
                }
            });            
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
            Button::make('create')->action('window.location.href = "' .'#'. '"')
            ->text("<i class='fas fa-plus'></i> " . trans("Tambah Journal"))
            ->addClass('bg-info'),
            Button::make('create')->action('window.location.href = "' . route("{$this->identifier}.backend.company.confirm_add").'"')
                ->text("<i class='fas fa-plus'></i> " . trans("label.add_new_{$this->company_category}"))
                ->addClass('bg-primary'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( !hasRoutePermission("{$this->identifier}.backend.company.confirm_add") || $this->viewed ){
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
                ->width('1%')->addClass('text-center')->addClass('align-middle')
                ->orderable(false)->searchable(false),
            Column::make('name')->title(trans('label.name_company'))->addClass('align-middle'),
            Column::make('nib')->title(trans('label.nib_company'))->addClass('text-center')->addClass('align-middle'),
            Column::make('sector.name')->title(trans('label.sector_company'))->addClass('align-middle'),
            Column::make('kbli_name_raw')->name('kbli.name')->title(trans('label.kbli'))->orderable(false)->searchable(false)->addClass('align-middle'),
            Column::make('negara.nama_negara')->title(trans('wilayah::label.country'))->visible(false)->addClass('align-middle'),
            Column::make('provinsi.nama_provinsi')->title(trans('wilayah::label.province'))->addClass('align-middle'),
            Column::make('name_director')->title(trans('label.name_director_of_company'))->addClass('align-middle'),
            Column::make('email_director')->visible(false)->addClass('align-middle'),
            Column::make('phone_director')->visible(false)->addClass('align-middle'),
            Column::make('name_pic')->title(trans('label.name_pic_of_company'))->addClass('align-middle'),
            Column::make('email_pic')->visible(false)->addClass('align-middle'),
            Column::make('phone_pic')->visible(false)->addClass('align-middle'),
            Column::make('company_status.statusRaw')->title(trans('label.status'))->addClass('text-center')->addClass('align-middle'),
            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('5%')
                ->addClass('text-center')
                ->addClass('align-middle'),
        ];
        if ($this->viewed){
            unset($columns[14]);
        }
        if (!hasRoutePermission("{$this->identifier}.backend.company.change_status") && $this->viewed) {
            unset($columns[13]);
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
        return 'companies_' . date('YmdHis');
    }
}
