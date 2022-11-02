<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Target;

use Plugins\BkpmUmkm\Models\TargetModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TargetDataTable extends DataTable
{
    protected $dataTableID = 'targetDatatable';
    protected $trash = 'all';
    protected $config;
    protected $identifier;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
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
            ->rawColumns(['target_UB'])
            ->rawColumns(['target_umkm'])
            ->rawColumns(['target_value'])
            ->rawColumns(['tahun'])
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';
                if ( hasRoute("{$this->identifier}.backend.target.edit") && hasRoutePermission("{$this->identifier}.backend.target.edit") && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-warning" href="'. route("{$this->identifier}.backend.target.edit", ['id'=>encrypt_decrypt($q->id)]) .'" title="'.trans('label.edit_business_sector').'"><i class="fas fa-edit"></i></a>';
                }
                if ( hasRoute("{$this->identifier}.backend.target.restore") && hasRoutePermission("{$this->identifier}.backend.target.restore") && $q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route("{$this->identifier}.backend.target.restore").'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i></a>';
                }

                if (hasRoutePermission(["{$this->identifier}.backend.target.soft_delete", "{$this->identifier}.backend.target.force_delete"])) {
                    $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute("{$this->identifier}.backend.target.soft_delete") && hasRoutePermission("{$this->identifier}.backend.target.soft_delete") && !$q->trashed()) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route("{$this->identifier}.backend.target.soft_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute("{$this->identifier}.backend.target.force_delete") && hasRoutePermission("{$this->identifier}.backend.target.force_delete")) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route("{$this->identifier}.backend.target.force_delete") . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                $html .= '</div>';

                return $html;
            })
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Plugins\BkpmUmkm\Models\TargetModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TargetModel $model)
    {
        $model = $model->select('*');
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
            Button::make('create')->action('window.location.href = "' . route("{$this->identifier}.backend.target.add").'"'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( !hasRoutePermission("{$this->identifier}.backend.target.add") ){
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
        return [
            Column::make('no_index', 'no_index')->title('No')
                ->width('1%')->addClass('text-center')
                ->orderable(false)->searchable(false),
            Column::make('target_UB'),
            Column::make('target_umkm'),
            Column::make('target_value'),
            Column::make('tahun'),
            Column::computed('action')->title('')
                ->orderable(false)->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width('5%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'target_' . date('YmdHis');
    }
}
