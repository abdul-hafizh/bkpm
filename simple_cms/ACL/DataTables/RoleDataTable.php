<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/30/20 4:41 PM ---------
 */

namespace SimpleCMS\ACL\DataTables;

use SimpleCMS\ACL\Models\RoleModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    protected $dataTableID = 'rolesDatatable';
    protected $trash = 'all';

    public function __construct()
    {
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
            ->eloquent($query)
            ->editColumn('permissions',function($q){
                return '<ul class="fa-ul"><li><i class="fa-li fas fa-link"></i> '. str_replace ("," , "</li><li><i class=\"fa-li fas fa-link\"></i> " , $q->permissions). '</li></ul>';
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';
                if ( hasRoute('simple_cms.acl.backend.role.edit') && hasRoutePermission('simple_cms.acl.backend.role.edit') && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-warning" href="'.route('simple_cms.acl.backend.role.edit',['id'=>encrypt_decrypt($q->id)]).'" title="Edit"><i class="fas fa-edit"></i></a>';
                }
                if ( hasRoute('simple_cms.acl.backend.role.restore') && hasRoutePermission('simple_cms.acl.backend.role.restore') && $q->trashed()){
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route('simple_cms.acl.backend.role.restore').'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i></a>';
                }
                $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                if ( hasRoute('simple_cms.acl.backend.role.soft_delete') && hasRoutePermission('simple_cms.acl.backend.role.soft_delete') && !$q->trashed()){
                    $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Trashed.!?" data-action="'.route('simple_cms.acl.backend.role.soft_delete').'" data-method="DELETE" data-value=\''. json_encode(['id'=>encrypt_decrypt($q->id)]) .'\'><i class="fa fa-trash"></i> Trash</a>';
                }
                if ( hasRoute('simple_cms.acl.backend.role.force_delete') && hasRoutePermission('simple_cms.acl.backend.role.force_delete') ){
                    $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Permanent delete.!?" data-action="'.route('simple_cms.acl.backend.role.force_delete').'" data-method="DELETE" data-value=\''. json_encode(['id'=>encrypt_decrypt($q->id)]) .'\'><i class="fa fa-times"></i> Delete</a>';
                }
                $html .= '</div>';

                if ( hasRoute('simple_cms.acl.backend.role.activity_log') && hasRoutePermission('simple_cms.acl.backend.role.activity_log') ){
                    $html .= '<a class="btn btn-xs btn-info show_modal_lg" href="javascript:void(0);" data-action="'.route('simple_cms.acl.backend.role.activity_log', ['log_name'=>encrypt_decrypt(LOG_ROLES), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: '.$q->name.'"><i class="fas fa-history"></i></a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['action','permissions'])
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \SimpleCMS\ACL\Models\RoleModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RoleModel $model)
    {
        $model = $model->where(function($q){
            if ( auth()->user()->role_id > 1 ){
                return $q->where('id', '>', 1);
            }
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
            Button::make('create')->action('window.location.href = "' . route('simple_cms.acl.backend.role.add').'"'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( auth()->user()->role_id >= 2 ){
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
            Column::make('name'),
            Column::make('description'),
            Column::computed('permissions')->orderable(false)->searchable(false),
            Column::computed('action')->title('')
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
        return 'role_' . date('YmdHis');
    }
}
