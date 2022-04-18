<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Survey;

use Illuminate\Support\Carbon;
use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\SurveyModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompanyBersediaDataTable extends DataTable
{
    protected $dataTableID = 'surveyCompanyBersediaDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_COMPANY;
    protected $status = 'bersedia';
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
            /*->addColumn('kbli_name_raw', function($q){
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
            })*/
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
                    $status .= '<a class="dropdown-item eventSurveyChangeStatus text-success" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('bersedia'), 'label_status' => trans("label.company_status_bersedia"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_bersedia") . '</a>';
                    $status .= '<a class="dropdown-item eventSurveyChangeStatus text-danger" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('tidak_bersedia'), 'label_status' => trans("label.company_status_tidak_bersedia"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_tidak_bersedia") . '</a>';
                    $status .= '<a class="dropdown-item eventSurveyChangeStatus text-warning" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('tidak_respon'), 'label_status' => trans("label.company_status_tidak_respon"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_tidak_respon") . '</a>';
                    $status .= '<a class="dropdown-item eventSurveyChangeStatus text-primary" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('konsultasi_bkpm'), 'label_status' => trans("label.company_status_konsultasi_bkpm"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_konsultasi_bkpm") . '</a>';
                    $status .= '<a class="dropdown-item eventSurveyChangeStatus text-info" href="javascript:void(0);" data-selecteddatatable="' . $this->dataTableID . '" data-action="' . route("{$this->identifier}.backend.company.change_status") . '" data-value=\''. json_encode(['id' => encrypt_decrypt($q->id), 'company_status_id' => encrypt_decrypt( ($q->company_status ? $q->company_status->id : '') ), 'status' => encrypt_decrypt('menunggu_konfirmasi'), 'label_status' => trans("label.company_status_menunggu_konfirmasi"), 'name_company' => $q->name ]) .'\'>' . trans("label.company_status_menunggu_konfirmasi") . '</a>';
                    $status .= '</div>';
                }
                $status .= '</div>';
                return $status;
            })
            ->rawColumns(['name_pic', 'company_status.statusRaw'])
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
            $q->where('companies_status.status', $this->status)->whereYear('companies_status.created_at', $this->periode);
        });
        switch ($this->user->group_id){
            case GROUP_QC_KORPROV:
            case GROUP_SURVEYOR:
                $model->where('companies.id_provinsi', $this->user->id_provinsi);
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                $model->whereIn('companies.id_provinsi', $provinces);
                break;
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
            Column::make("name")->title(trans("label.name_{$this->company_category}")),
            Column::make("nib")->title(trans("label.nib_{$this->company_category}")),
            Column::make("provinsi.nama_provinsi")->title(trans('wilayah::label.province')),
            Column::make("address")->title(trans("label.address_{$this->company_category}")),
            Column::make("name_pic")->title(trans("label.name_pic_of_{$this->company_category}")),
            Column::make('company_status.statusRaw')->title(trans('label.status')),
        ];
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
        return "{$this->company_category}_bersedia_" . date('YmdHis');
    }
}
