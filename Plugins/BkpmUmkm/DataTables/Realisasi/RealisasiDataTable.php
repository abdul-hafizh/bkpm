<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Kemitraan;

use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\KemitraanModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RealisasiDataTable extends DataTable
{
    protected $dataTableID = 'kemitraanDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $status = 'bersedia';
    protected $category_company = CATEGORY_COMPANY;
    protected $category_umkm = CATEGORY_UMKM;
    protected $periode, $wilayah_id, $provinsi_id;
    protected $viewed = false;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
        $this->periode = (request()->has('periode') && filter(request()->input('periode')) != '' ? filter(request()->input('periode')) : \Carbon\Carbon::now()->format('Y'));
        $this->wilayah_id = (request()->has('wilayah_id') && filter(request()->input('wilayah_id')) != '' ? filter(request()->input('wilayah_id')) : 'all');
        $this->provinsi_id = (request()->has('provinsi_id') && filter(request()->input('provinsi_id')) != '' ? filter(request()->input('provinsi_id')) : 'all');

        $inModal = request()->get('in-modal');
        if ($inModal){
            $this->viewed = true;
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
            ->editColumn("{$this->category_company}.name", function($q){
                $name = $q->{$this->category_company}->name;
                if ( hasRoute("{$this->identifier}.backend.survey.detail_survey") && hasRoutePermission("{$this->identifier}.backend.survey.detail_survey") && $q->{$this->category_company}->survey ){
                    $name = '<a href="javascript:void(0);" class="show_modal_ex_lg" data-action="'. route("{$this->identifier}.backend.survey.detail_survey", ['company' => $this->category_company, 'survey'=>encrypt_decrypt($q->{$this->category_company}->survey->id), 'in_modal' => true]) .'" data-method="GET" title="'.trans("label.survey_detail_survey_{$this->category_company}").'">'. $name .'</a>';
                }
                $html = '<div class="user-block">
                                <span class="username ml-1"><a>'. $name .'</a></span>
                                <span class="description ml-1">
                                    <i class="fas fa-sort-numeric-up"></i> ' . ($q->{$this->category_company}->nib ? $q->{$this->category_company}->nib : '-') . '
                                    <br/><i class="fas fa-map-marker-alt"></i> ' . ($q->{$this->category_company}->provinsi ? $q->{$this->category_company}->provinsi->nama_provinsi : '-') . '
                                    '. (!empty($q->{$this->category_company}->name_pic) ? '<br/><i class="fas fa-user"></i> ' . $q->{$this->category_company}->name_pic : '') . '
                                    '. (!empty($q->{$this->category_company}->email_pic) ? '<br/><i class="fas fa-envelope"></i> ' . $q->{$this->category_company}->email_pic : '') . '
                                    '. (!empty($q->{$this->category_company}->phone_pic) ? '<br/><i class="fas fa-phone"></i> ' . $q->{$this->category_company}->phone_pic : '') . '
                                </span>
                            </div>';
                return $html;
            })
            ->editColumn("{$this->category_company}.provinsi.nama_provinsi", function($q){
                return ($q->{$this->category_company}->provinsi ? $q->{$this->category_company}->provinsi->nama_provinsi : '-');
            })
            ->rawColumns(["{$this->category_company}.name", "{$this->category_umkm}.name", 'statusRaw', 'file_kerjasama', 'file_kontrak', 'action'])
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

        $model = $model->whereIn("kemitraan.status", ['bersedia'])
            ->with([$this->category_company => function($q){
                return $q->with(['survey' => function($q){
                    return $q->whereYear('surveys.created_at', $this->periode);
                }]);
            }, $this->category_umkm => function($q){
                return $q->with(['survey' => function($q){
                    return $q->whereYear('surveys.created_at', $this->periode);
                }]);
            }])
            ->whereHas($this->category_company, function($q){
                switch ($this->user->group_id){
                    case GROUP_QC_KORPROV:
                        $q->where('companies.id_provinsi', $this->user->id_provinsi);
                        break;
                    case GROUP_QC_KORWIL:
                    case GROUP_ASS_KORWIL:
                    case GROUP_TA:
                        $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                        $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                        if ($this->provinsi_id&&$this->provinsi_id!=='all'&&in_array($this->provinsi_id, $provinces)){
                            $provinces = [$this->provinsi_id];
                        }
                        $q->whereIn('companies.id_provinsi', $provinces);
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
                            $q->whereIn('companies.id_provinsi', $provinces);
                        }
                        break;
                }
            });

        $model->whereYear('kemitraan.created_at', $this->periode);
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
            Column::make("{$this->category_company}.name")->title(trans("label.name_{$this->category_company}")),
            Column::make("{$this->category_company}.nib")->title(trans("label.nib_{$this->category_company}"))->visible(false),
            Column::make("{$this->category_company}.provinsi.nama_provinsi")->title(trans('wilayah::label.province'))->orderable(false)->searchable(false)            
        ];
        if ($this->viewed){
            unset($columns[12]);
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
        return "kemitraan_{$this->category_reverse}_" . date('YmdHis');
    }
}
