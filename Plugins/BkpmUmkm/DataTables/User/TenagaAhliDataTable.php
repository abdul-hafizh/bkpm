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

class TenagaAhliDataTable extends DataTable
{
    protected $dataTableID = 'tenagaAhliDatatable';
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
        $this->dw = request()->get('dw');
        $this->dw = ($this->dw ? encrypt_decrypt($this->dw, 2) : '' );
        $this->dw_selected = (!empty($this->dw) ? $this->dw : 0);
        $this->periode = request()->get('periode', $current_year);
        /*config()->set('database.connections.mysql.strict', false);
        \DB::reconnect();*/
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
            ->editColumn('has_verified_count', function($q){
                if (hasRoutePermission("{$this->identifier}.backend.rekap_laporan.tenaga_ahli_daftar_verified"))
                {
                    return '<a class="show_modal_ex_lg" href="javascript:void(0);" data-action="'.route("{$this->identifier}.backend.rekap_laporan.tenaga_ahli_daftar_verified", ['periode'=>$this->periode, 'user_id'=>encrypt_decrypt($q->id)]).'" data-method="GET" title="Daftar yang diverifikasi oleh : ' . $q->name .'">'. $q->has_verified_count .'</a>';
                }
                return $q->has_verified_count;
            })
            ->rawColumns(['has_verified_count'])
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
        $model = $model->select('users.*')
            ->with(['provinsi', 'kabupaten']);
        $model = $model->selectRaw("(select count(surveys.id) from surveys where exists (select * from `activity_log` where `surveys`.`id` = `activity_log`.`subject_id` and `causer_id` = `users`.`id` and year(`activity_log`.`updated_at`) = '{$this->periode}' and (`activity_log`.`log_name` = 'LOG_SURVEY' and `activity_log`.`group` = 'change_status_survey.verified'))) as has_verified_count");
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
        $model->where('users.group_id', GROUP_TA)->whereIn('users.id_provinsi', $provinsi_in);

        $model = $model->whereHas('do_verified_surveys', function($q){
            $q->whereYear('activity_log.updated_at', $this->periode);
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
            Column::make('name')->title(trans('label.nama_tenaga_ahli')),
            Column::make('email')->title(trans('label.email')),
            Column::make('mobile_phone')->title(trans('label.mobile_phone')),
            Column::make('provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('kabupaten.nama_kabupaten')->title(trans('wilayah::label.kabupaten')),
            Column::make('has_verified_count')->title(trans('label.total_verified'))->addClass('text-center')
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
        return "tenaga-ahli-{$this->periode}" . date('YmdHis');
    }
}
