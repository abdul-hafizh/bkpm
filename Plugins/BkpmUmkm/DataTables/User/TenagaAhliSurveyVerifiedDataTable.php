<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\User;

use Illuminate\Support\Carbon;
use Plugins\BkpmUmkm\Models\SurveyModel;
use SimpleCMS\ACL\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TenagaAhliSurveyVerifiedDataTable extends DataTable
{
    protected $dataTableID = 'tenagaAhliSurveyVerifiedDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;
    protected $user;
    protected $periode;
    protected $user_id;
    protected $user_verified;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();

        $current_year = \Carbon\Carbon::now()->format('Y');
        $this->periode = filter(request()->get('periode', $current_year));
        $this->user_id = encrypt_decrypt(filter($this->request()->get('user_id')), 1);
        $this->user_verified = User::find($this->user_id);
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
            ->editColumn('company.name', function($q){
                return $q->company->name;
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
            ->editColumn('company.provinsi.nama_provinsi', function($q){
                return ($q->company && $q->company->provinsi ? $q->company->provinsi->nama_provinsi : '-');
            })
            ->editColumn('company.address', function($q){
                return ($q->company && $q->company->address ? nl2br($q->company->address) : '-');
            })
            ->addColumn('periode', function ($q){
                return $q->created_at->format('Y');
            })
            ->rawColumns(['company.name', 'company.address', 'surveyor.name'])
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
        $model = $model->whereHas('company')
            ->with(['company', 'company.provinsi', 'surveyor'])
            ->whereYear('surveys.created_at', $this->periode)
            ->whereHas('do_verified', function ($q){
                $q->whereCauserId($this->user_id)->whereYear('activity_log.updated_at', $this->periode);
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
            Column::make('company.name')->title(trans('label.name_company')),
            Column::make('company.provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('company.address')->title(trans('label.address_company')),
            Column::make('surveyor.name')->title(trans('label.name_surveyor')),
            Column::make('periode')->name('created_at')->title(trans('label.year'))->orderable(false)
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
        return "tenaga-ahli{$this->user_verified->name}-{$this->periode}" . date('YmdHis');
    }
}
