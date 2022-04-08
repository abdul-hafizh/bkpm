<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/30/20 4:41 PM ---------
 */

namespace SimpleCMS\ACL\DataTables;

use SimpleCMS\ACL\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    protected $dataTableID = 'usersDatatable';
    protected $trash = 'all';
    protected $user;

    public function __construct()
    {
        $this->trash    = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user     = auth()->user();
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
            ->editColumn('group.name', function($q){
                return ($q->group ? $q->group->name : '-');
            })
            ->editColumn('role.name', function($q){
                return ($q->role ? $q->role->name : '-');
            })
            ->editColumn('provinsi.nama_provinsi', function($q){
                return ($q->provinsi ? $q->provinsi->nama_provinsi : '-');
            })
            ->editColumn('kabupaten.nama_kabupaten', function($q){
                return ($q->kabupaten ? $q->kabupaten->nama_kabupaten : '-');
            })
            ->editColumn('status', function($q){
                return '<span '. ($q->status == 1 ? 'class="text-success" title="Active"' : 'class="text-muted" title="Inactive"') .'"><i class="fas fa-power-off"></i></span>';
            })
            ->addColumn('action', function ($q){
                $html = '';

                $html = '<div class="btn-group btn-group-xs">';
                if (hasRoute('simple_cms.acl.backend.user.edit') && hasRoutePermission('simple_cms.acl.backend.user.edit') && !$q->trashed()) {
                    $html .= '<a class="btn btn-xs btn-warning" href="' . route('simple_cms.acl.backend.user.edit', ['id' => encrypt_decrypt($q->id)]) . '" title="Edit"><i class="fas fa-edit"></i></a>';
                }
                if (hasRoute('simple_cms.acl.backend.user.restore') && hasRoutePermission('simple_cms.acl.backend.user.restore') && $q->trashed()) {
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Restore.!?" data-action="' . route('simple_cms.acl.backend.user.restore') . '" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-refresh"></i></a>';
                }

                if (hasRoutePermission([
                    'simple_cms.acl.backend.user.soft_delete',
                    'simple_cms.acl.backend.user.force_delete'
                ])) {
                    $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                      <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute('simple_cms.acl.backend.user.soft_delete') && hasRoutePermission('simple_cms.acl.backend.user.soft_delete') && !$q->trashed()) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route('simple_cms.acl.backend.user.soft_delete') . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute('simple_cms.acl.backend.user.force_delete') && hasRoutePermission('simple_cms.acl.backend.user.force_delete')) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route('simple_cms.acl.backend.user.force_delete') . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                if (hasRoute('simple_cms.acl.backend.user.activity_log') && hasRoutePermission('simple_cms.acl.backend.user.activity_log')) {
                    $html .= '<a class="btn btn-xs btn-info show_modal_lg" href="javascript:void(0);" data-action="' . route('simple_cms.acl.backend.user.activity_log', ['log_name' => encrypt_decrypt(LOG_ACCOUNT), 'subject' => encrypt_decrypt($q->id)]) . '" title="History: ' . $q->name . '"><i class="fas fa-history"></i></a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['status','action'])
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
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
        $model = $model->select('users.*')->where(function($q){
            if ( $this->user->group_id > 1 ){
                return $q->whereIn('group_id', [
                    GROUP_ADMIN,
                    GROUP_SURVEYOR,
                    GROUP_QC_KOROP,
                    GROUP_QC_KORWIL,
                    GROUP_QC_KORPROV,
                    GROUP_SURVEYOR,
                    GROUP_TA,
                    GROUP_ASS_KORWIL
                ]);
            }
        })->with('provinsi', 'kabupaten');

        if (!in_array($this->user->group_id, [GROUP_SUPER_ADMIN, GROUP_ADMIN])){
            $model->where('group_id', GROUP_SURVEYOR);
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
        return $model->with(['role','group'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [
            Button::make('create')->action('window.location.href = "' . route('simple_cms.acl.backend.user.add').'"'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( hasRoute('simple_cms.acl.backend.user.add') && !hasRoutePermission('simple_cms.acl.backend.user.add') ){
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
            /*
            ->stateSave()
            ->info(true)
            ->fixedHeader()
            ->responsive()*/
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
            Column::make('id')->title('ID'),
            Column::make('username'),
            Column::make('name'),
            Column::make('email'),
            Column::make('provinsi.nama_provinsi')->title(trans('wilayah::label.province')),
            Column::make('kabupaten.nama_kabupaten')->title(trans('wilayah::label.city_district')),
            Column::make('group.name')->title('Group'),
            Column::make('role.name')->title('Role'),
            Column::make('status')->title('Status')->width('5%')->addClass('text-center'),
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
        return 'User_' . date('YmdHis');
    }
}
