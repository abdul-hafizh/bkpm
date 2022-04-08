<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace SimpleCMS\Blog\DataTables;

use Illuminate\Support\Facades\DB;
use SimpleCMS\Blog\Models\PostModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PostDataTable extends DataTable
{
    protected $dataTableID = 'postsDatatable';
    protected $trash = 'all';
    protected $user;

    public function __construct()
    {
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->user = auth()->user();
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
            ->editColumn('title', function($q){
                return view_language('title', $q);
            })
            ->addColumn('categoriesRaw', function($q){
                $categories = $q->list_tag_categories(['title' => 'Edit: '], true);
                return '<span class="f-s-13">' . implode(', ', $categories) . '</span>';
            })
            /*->addColumn('tagsRaw', function($q){
                $tags = $q->list_tag_tags(['title' => 'Edit: '], true);
                return '<span class="f-s-13">' . implode(', ', $tags) . '</span>';
            })*/
            ->editColumn('status', function ($q){
                $status = ucwords(str_replace('-', ' ', $q->status));
                switch ($q->status)
                {
                    case 'publish':
                        $class = 'success';
                        break;
                    case 'member':
                        $class = 'info';
                        break;
                    case 'draft':
                        $class = 'warning';
                        break;
                    case 'submission':
                        $class = 'secondary';
                        break;
                    case 'rejected':
                        $class = 'danger';
                        break;
                    default:
                        $class = 'default';
                        break;
                }
                $html = '<div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-'. $class .'" title="Status: '. $status .'">'. $status .'</button>';
                if (hasRoutePermission('simple_cms.blog.backend.post.save_update')) {
                    if ($this->user->group_id <= 2 && $q->user->group_id > 2 && in_array($q->status, ['draft', 'rejected'])) {
                        $class .= ' d-none';
                    }
                    $html .= '<button type="button" class="btn btn-' . $class . ' dropdown-toggle dropdown-icon" title="Change Status" data-toggle="dropdown"></button>
                                <div class="dropdown-menu pt-0 pb-0 dropdown-menu-right">';
                        if ($this->user->group_id <= 2) {
                            $html .= '<a class="dropdown-item eventDataTableChangeStatus text-success ' . ($q->status == 'publish' ? 'd-none' : '') . '" href="javascript:void(0);" data-action="' . route('simple_cms.blog.backend.post.save_update', ['change_status' => encrypt_decrypt($q->id . '|publish')]) . '" data-selecteddatatable="' . $this->dataTableID . '" title="Change status to: Publish">Publish</a>
                                    <a class="dropdown-item eventDataTableChangeStatus text-info ' . ($q->status == 'member' ? 'd-none' : '') . '" href="javascript:void(0);" data-action="' . route('simple_cms.blog.backend.post.save_update', ['change_status' => encrypt_decrypt($q->id . '|member')]) . '" data-selecteddatatable="' . $this->dataTableID . '" title="Change status to: Member">Member</a>';
                            if ($q->user_id == $this->user->id) {
                                $html .= '<a class="dropdown-item eventDataTableChangeStatus text-warning ' . ($q->status == 'draft' ? 'd-none' : '') . '" href="javascript:void(0);" data-action="' . route('simple_cms.blog.backend.post.save_update', ['change_status' => encrypt_decrypt($q->id . '|draft')]) . '" data-selecteddatatable="' . $this->dataTableID . '" title="Change status to: Draft">Draft</a>';
                            }
                            if ($q->user->group_id > 2) {
                                $html .= '<a class="dropdown-item eventDataTableChangeStatus text-danger ' . ($q->status == 'rejected' ? 'd-none' : '') . '" href="javascript:void(0);" data-action="' . route('simple_cms.blog.backend.post.save_update', ['change_status' => encrypt_decrypt($q->id . '|rejected')]) . '" data-selecteddatatable="' . $this->dataTableID . '" title="Change status to: Rejected">Rejected</a>';
                            }
                        }else{
                            $html .= '<a class="dropdown-item eventDataTableChangeStatus text-secondary ' . ($q->status == 'submission' ? 'd-none' : '') . '" href="javascript:void(0);" data-action="' . route('simple_cms.blog.backend.post.save_update', ['change_status' => encrypt_decrypt($q->id . '|submission')]) . '" data-selecteddatatable="' . $this->dataTableID . '" title="Change status to: Submission">Submission</a>
                                    <a class="dropdown-item eventDataTableChangeStatus text-warning ' . ($q->status == 'draft' ? 'd-none' : '') . '" href="javascript:void(0);" data-action="' . route('simple_cms.blog.backend.post.save_update', ['change_status' => encrypt_decrypt($q->id . '|draft')]) . '" data-selecteddatatable="' . $this->dataTableID . '" title="Change status to: Draft">Draft</a>';
                        }

                    $html .= '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->editColumn('created_at', function($q){
                $formatDate = formatDate($q->created_at, 1,1,1,1);
                return '<span class="pointer-cursor" title="'.$formatDate.'">'.$q->created_at->diffForHumans().'</span>';
            })
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';

                if ( hasRoute('simple_cms.blog.backend.post.edit') && hasRoutePermission('simple_cms.blog.backend.post.edit') && !$q->trashed() ){
                    $html .= '<a class="btn btn-xs btn-warning" href="'.route('simple_cms.blog.backend.post.edit', ['post_slug' => $q->slug]).'" title="Edit '.$q->name.'"><i class="fas fa-edit"></i></a>';
                }
                if ( hasRoute('simple_cms.blog.backend.post.restore') && hasRoutePermission('simple_cms.blog.backend.post.restore') && $q->trashed()){
                    $html .= '<a class="btn btn-xs btn-info eventDataTableRestore" data-selecteddatatable="'.$this->dataTableID.'" href="javascript:void(0);" title="Restore.!?" data-action="'.route('simple_cms.blog.backend.post.restore').'" data-value=\''.json_encode(['id'=>encrypt_decrypt($q->id)]).'\'><i class="fa fa-refresh"></i></a>';
                }

                if (hasRoutePermission(['simple_cms.blog.backend.post.soft_delete', 'simple_cms.blog.backend.post.force_delete'])) {
                    $html .= '<button type="button" class="btn btn-danger dropdown-toggle dropdown-icon btn-xs" data-toggle="dropdown"> <i class="fas fa-trash"></i> </button>
                          <div class="dropdown-menu  dropdown-menu-right">';
                    if (hasRoute('simple_cms.blog.backend.post.soft_delete') && hasRoutePermission('simple_cms.blog.backend.post.soft_delete') && !$q->trashed()) {
                        $html .= '<a class="dropdown-item text-warning eventDataTableSoftDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Trashed.!?" data-action="' . route('simple_cms.blog.backend.post.soft_delete') . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-trash"></i> Trash</a>';
                    }
                    if (hasRoute('simple_cms.blog.backend.post.force_delete') && hasRoutePermission('simple_cms.blog.backend.post.force_delete')) {
                        $html .= '<a class="dropdown-item text-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route('simple_cms.blog.backend.post.force_delete') . '" data-method="DELETE" data-value=\'' . json_encode(['id' => encrypt_decrypt($q->id)]) . '\'><i class="fa fa-times"></i> Delete</a>';
                    }
                    $html .= '</div>';
                }

                if ( hasRoute('simple_cms.blog.backend.post.activity_log') && hasRoutePermission('simple_cms.blog.backend.post.activity_log') ){
                    $html .= '<a class="btn btn-xs btn-info show_modal_lg" href="javascript:void(0);" data-action="'.route('simple_cms.blog.backend.post.activity_log', ['log_name'=>encrypt_decrypt(LOG_POST), 'subject'=>encrypt_decrypt($q->id)]).'" title="History: '.$q->title.'"><i class="fas fa-history"></i></a>';
                }
                if (in_array($q->status, ['publish', 'member'])) {
                    $html .= '<a class="btn btn-xs btn-secondary" href="' . $q->url() . '" target="_blank" title="View in live"><i class="fas fa-link"></i></a>';
                }

                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['title', 'categoriesRaw', 'tagsRaw', 'status', 'created_at', 'action'])
            ->setRowClass(function($q){
                return ($q->trashed() ? 'bg-trashed':'');
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \SimpleCMS\Blog\Models\PostModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PostModel $model)
    {
        $model = $model->select('posts.*')->where(function($q){
            return $q->whereIn('posts.type', ['post']);
        })->with(['categories' => function($q){
            $q->select('categories.id', 'categories.slug', 'categories.name');
        }, 'user' => function($q){
            $q->select('users.id', 'users.group_id', 'users.name', 'users.email');
        }])->withCount(['views']);
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
        if ($this->user->group_id > 2){
            $model->where('posts.user_id', $this->user->id);
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
            Button::make('create')->action('window.location.href = "' . route('simple_cms.blog.backend.post.add').'"'),
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( !hasRoutePermission('simple_cms.blog.backend.post.add') ){
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
            ->orderBy(7)
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
//            Column::make('no_index', 'no_index')->title('No')
//                ->width('1%')->addClass('text-center')
//                ->orderable(false)->searchable(false),
            Column::make('id')->name('id')->width('1%')->addClass('text-center text-uppercase'),
            Column::make('title')->name('title'),
            Column::make('user.name')->name('user.name')->title('Author')->width('10%'),
            Column::make('categoriesRaw')->name('categories.name')->title('Categories')->width('15%')->orderable(false)->searchable(false),
//            Column::make('tagsRaw')->name('tags.name')->title('Tags')->width('15%')->orderable(false)->searchable(false),
            Column::make('viewed')->name('views_count')->title('Views')->width('1%')->addClass('text-center')->searchable(false),
            Column::make('status')->name('status')->width('5%')->addClass('text-center'),
            Column::make('created_at')->name('created_at')->title('Created at')->width('10%'),
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
        return 'posts_' . date('YmdHis');
    }
}
