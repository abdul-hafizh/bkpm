<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\User;

use Illuminate\Support\Carbon;
use SimpleCMS\ACL\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TenagaSurveyorDataTable extends DataTable
{
    protected $dataTableID = 'tenagaSurveyorDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $dw_selected = 0;
    protected $periode, $dw;
    protected $current_wilayah;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();

        $current_year = \Carbon\Carbon::now()->format('Y');
        $this->dw = filter(request()->get('dw'));
        $this->dw = ($this->dw ? encrypt_decrypt($this->dw, 2) : '' );
        $this->dw_selected = (!empty($this->dw) ? $this->dw : 0);
        $this->periode = filter(request()->get('periode', $current_year));
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
            ->editColumn("provinsi.nama_provinsi", function($q){
                return ($q->provinsi ? $q->provinsi->nama_provinsi : '-');
            })
            ->editColumn("kabupaten.nama_kabupaten", function($q){
                return ($q->kabupaten ? $q->kabupaten->nama_kabupaten : '-');
            })
            ->editColumn("mobile_phone", function($q){
                return ($q->mobile_phone ? $q->mobile_phone : '-');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \SimpleCMS\ACL\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $model = $model->with(['provinsi', 'kabupaten']);
        $provinsi_in = [];
        switch ($this->user->group_id){
            case GROUP_SURVEYOR:
            case GROUP_QC_KORPROV:
                $current_wilayah = bkpmumkm_wilayah($this->user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => [$this->user->id_provinsi]
                ];
                $provinsi_in = [$this->user->id_provinsi];
                $this->dw_selected = $current_wilayah['index'];
                $this->current_wilayah = $current_wilayah['name'];
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $current_wilayah = bkpmumkm_wilayah($this->user->id_provinsi);
                $params['bkpmumkm_wilayah'][$current_wilayah['index']] = [
                    "name"      => $current_wilayah["name"],
                    "provinces" => $current_wilayah["provinces"]
                ];
                $provinsi_in = $current_wilayah["provinces"];
                $this->dw_selected = $current_wilayah['index'];
                $this->current_wilayah = $current_wilayah['name'];
                break;
            default:
                $params['bkpmumkm_wilayah'] = simple_cms_setting('bkpmumkm_wilayah');
                $provinsi_in = $params['bkpmumkm_wilayah'][$this->dw_selected]["provinces"];
                $this->current_wilayah = $params['bkpmumkm_wilayah'][$this->dw_selected]['name'];
                break;
        }
        $model->where('users.group_id', GROUP_SURVEYOR)->whereIn('users.id_provinsi', $provinsi_in);

        $model = $model->whereHas('surveys', function($q){
            $q->whereYear('surveys.created_at', $this->periode);
        });

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
            Column::make('name')->title(trans('label.name_surveyor')),
            Column::make('email')->title(trans('label.email')),
            Column::make('provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('kabupaten.nama_kabupaten')->title(trans('wilayah::label.kabupaten')),
            Column::make('mobile_phone')->title(trans('label.telp_surveyor'))
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
        return "tenaga-surveyor-{$this->current_wilayah}-{$this->periode}-" . date('YmdHis');
    }
}
