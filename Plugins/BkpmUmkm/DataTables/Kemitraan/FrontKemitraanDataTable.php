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

class FrontKemitraanDataTable extends DataTable
{
    protected $dataTableID = 'frontKemitraanDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $status = 'bersedia';
    protected $category_company = CATEGORY_COMPANY;
    protected $category_umkm = CATEGORY_UMKM;
    protected $periode;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        /*$this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();*/
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
            ->editColumn("{$this->category_company}.name", function($q){
                $html = '<div class="user-block">
                                <span class="username ml-1"><a>'. $q->{$this->category_company}->name .'</a></span>
                                <span class="description ml-1 f-s-13">
                                    <br/><i class="fas fa-map-marker-alt"></i> ' . ($q->{$this->category_company}->provinsi ? $q->{$this->category_company}->provinsi->nama_provinsi : '-') . '
                                </span>
                            </div>';
                return $html;
            })
            ->editColumn("{$this->category_company}.provinsi.nama_provinsi", function($q){
                return ($q->{$this->category_company}->provinsi ? $q->{$this->category_company}->provinsi->nama_provinsi : '-');
            })
            ->editColumn("{$this->category_umkm}.name", function($q){
                $html = '<div class="user-block">
                                <span class="username ml-1"><a>'. $q->{$this->category_umkm}->name .'</a></span>
                                <span class="description ml-1 f-s-14">
                                    <br/><i class="fas fa-map-marker-alt"></i> ' . ($q->{$this->category_umkm}->provinsi ? $q->{$this->category_umkm}->provinsi->nama_provinsi : '-') . '
                                </span>
                            </div>';
                return $html;
            })
            ->rawColumns(["{$this->category_company}.name", "{$this->category_umkm}.name"])
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

        $model = $model->select('kemitraan.id', 'kemitraan.company_id', 'kemitraan.umkm_id', 'kemitraan.status', 'kemitraan.created_at', 'kemitraan.deleted_at')->whereIn("kemitraan.status", ['bersedia'])
            ->with([$this->category_company => function($q){
                $q->select('companies.id', 'companies.name', 'companies.deleted_at', 'companies.id_provinsi');
            }, $this->category_umkm => function($q){
                $q->select('companies.id', 'companies.name', 'companies.deleted_at', 'companies.id_provinsi');
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
            Button::make('reset')->addClass('d-none')
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
            ->minifiedAjax(route('simple_cms.plugins.bkpmumkm.api.kemitraan'),$script)
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
            Column::make("{$this->category_company}.name")->title(trans("label.name_{$this->category_company}")),

            Column::make("{$this->category_company}.provinsi.nama_provinsi")->title(trans('wilayah::label.province'))->orderable(false)->searchable(false),

            Column::make("{$this->category_umkm}.name")->title(trans("label.name_{$this->category_umkm}"))
        ];
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
