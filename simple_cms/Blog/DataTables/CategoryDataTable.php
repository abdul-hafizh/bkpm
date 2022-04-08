<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace SimpleCMS\Blog\DataTables;

use SimpleCMS\Blog\Models\CategoryModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
{
    protected $dataTableID = 'categoryDatatable';
    protected $trash = 'all';
    protected $whereType = 'post';

    public function __construct()
    {
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        if ( request()->get('type') && !empty(filter(request()->get('type'))) ){
            $this->whereType = filter(request()->get('type'));
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
            ->of($query)
            ->editColumn('name', function ($q){
                return view_language('name', $q);
            })
            ->editColumn('description', function ($q){
                return view_language('description', $q);
            })
            ->editColumn('parent.name', function ($q){
                return ($q->parent ? view_language('name', $q->parent) : '-');
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';
                if ( hasRoute('simple_cms.blog.backend.category.edit') && hasRoutePermission('simple_cms.blog.backend.category.edit') && is_null($q->deleted_at) ){
                    $html .= '<a class="btn btn-xs btn-warning" href="'.route('simple_cms.blog.backend.category.edit', ['id' => encrypt_decrypt($q->id), 'type' => $this->whereType]).'" title="Edit Category"><i class="fas fa-edit"></i></a>';
                }
                if ( hasRoute('simple_cms.blog.backend.category.restore') && hasRoutePermission('simple_cms.blog.backend.category.restore') && !is_null($q->deleted_at)){
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route('simple_cms.blog.backend.category.restore').'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i></a>';
                }

                if (hasRoutePermission(['simple_cms.blog.backend.category.soft_delete', 'simple_cms.blog.backend.category.force_delete'])) {
                    $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute('simple_cms.blog.backend.category.soft_delete') && hasRoutePermission('simple_cms.blog.backend.category.soft_delete') && is_null($q->deleted_at)) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route('simple_cms.blog.backend.category.soft_delete') . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute('simple_cms.blog.backend.category.force_delete') && hasRoutePermission('simple_cms.blog.backend.category.force_delete')) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route('simple_cms.blog.backend.category.force_delete') . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                if ( hasRoute('simple_cms.blog.backend.category.activity_log') && hasRoutePermission('simple_cms.blog.backend.category.activity_log') ){
                    $html .= '<a class="btn btn-xs btn-info show_modal_lg" href="javascript:void(0);" data-action="'.route('simple_cms.blog.backend.category.activity_log', ['log_name'=>encrypt_decrypt(LOG_CATEGORY), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: '.$q->name.'"><i class="fas fa-history"></i></a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['name', 'description', 'parent.name', 'action'])
            ->setRowClass(function($q){
                return (!is_null($q->deleted_at) ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \SimpleCMS\Blog\Models\CategoryModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CategoryModel $model)
    {
        $model = $model->with(['parent'])->where(function($q){
            $q->where('type', '=', $this->whereType);
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
            Button::make('create')->action('window.location.href = "' . route('simple_cms.blog.backend.category.add', ['type' => $this->whereType]).'"'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( !hasRoutePermission('simple_cms.blog.backend.category.add') ){
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
            Column::make('parent.name')->title('Parent')->orderable(false)->searchable(false),
            Column::make('description'),
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
        return 'categories_' . date('YmdHis');
    }
}
