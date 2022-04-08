<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 10:44 PM ---------
 */

namespace SimpleCMS\ActivityLog\DataTables;

use SimpleCMS\ActivityLog\Models\Activity;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ActivityLogAllDataTable extends DataTable
{
    protected $mode = 'user';
    protected $log_name = 'all';
    protected $subject = '';
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
        if ( $this->request()->has('log_name') && !empty(filter($this->request()->input('log_name'))) ) {
            $this->log_name = encrypt_decrypt(filter($this->request()->input('log_name')), 2);
            $this->mode = 'subject';
            if ( $this->request()->has('subject') && !empty(filter($this->request()->input('subject'))) ){
                $this->subject = encrypt_decrypt(filter($this->request()->input('subject')), 2);
            }
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
        $datatable = datatables()
            ->eloquent($query)
            ->editColumn('description', function($q){
                $html = shortcodes($q->description);
                if ($q->user_requests){
                    $user_request = $q->user_requests;
                    $html .= '<hr/>';
                    $html .= "<strong>Client IP:</strong> {$user_request['client_ip']}<br/>";
                    $html .= "<strong>User agent:</strong> {$user_request['user_agent']}";
                }
                return $html;
            })
            ->editColumn('causer.name', function($q){
                return ($q->causer ? $q->causer->name : '-');
            })
            ->editColumn('causer.group.name', function($q){
                return ($q->causer && $q->causer->group ? $q->causer->group->name : '-');
            })
            ->editColumn('created_at', function($q){
                $formatDate = formatDate($q->created_at, 1,1,1,1);
                $html = '<span class="f-s-15">'.$formatDate.'</span>';
                $html .= '<br/>';
                $html .= '<small>'.$q->created_at->diffForHumans().'</small>';
                return $html;
            });

        $datatable->rawColumns(['created_at','description'])
            ->addIndexColumn();
        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \SimpleCMS\ActivityLog\Models\Activity $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Activity $model)
    {
        $model = $model->latest()->with(['causer']);
        if ($this->log_name !== 'all'){
            $model->inLog($this->log_name);
        }
        /*if (!empty($this->subject)){
            $model->where('subject_id', $this->subject);
        }*/
        switch ($this->user->group_id){
            case GROUP_SURVEYOR:
                $model->where('activity_log.causer_id', $this->user->id);
                break;
            case GROUP_QC_KORPROV:
                $model->whereHas('causer', function ($q){
                    $q->whereIn('users.group_id', [GROUP_SURVEYOR])->where('users.id_provinsi', $this->user->id_provinsi);
                });
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            // case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $model->whereHas('causer', function ($q) use($provinces){
                    $group_in = [GROUP_SURVEYOR, GROUP_QC_KORPROV];
                    switch ($this->user->group_id){
                        case GROUP_TA;
                            array_push($group_in, GROUP_QC_KORWIL, GROUP_ASS_KORWIL);
                            break;
                        case GROUP_QC_KORWIL:
                            array_push($group_in, GROUP_ASS_KORWIL);
                            break;
                    }
                    $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                    $q->whereIn('users.group_id', $group_in)->whereIn('users.id_provinsi', $provinces);
                });
                break;
            default:

                break;
        }
        return $model->newQuery();
        /*switch ($this->mode){
            case 'subject':
                $model = $model->inLog($this->log_name)->latest()->with(['causer']);
                if (!empty($this->subject)){
                    $model->where('subject_id', $this->subject);
                }
                return $model->newQuery();
                break;
            default:
                return $model->whereUser()->latest()->newQuery();
                break;

        }*/
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];

        return $this->builder()
            ->addTableClass('table table-bordered table-hover table-sm')
            ->setTableId('activityLogDatatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            Column::make('log_name')->title('Jenis Log'),
            Column::make('group')->title('Kelompok Log'),
            Column::make('description')->title('Deskripsi'),
            Column::make('causer.name')->title('Oleh')->orderable(false)->searchable(false),
            Column::make('causer.group.name')->title('Kelompok User')->orderable(false)->searchable(false),
            Column::make('created_at')->title('Tanggal Log')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'activitylog_' . date('YmdHis');
    }
}
