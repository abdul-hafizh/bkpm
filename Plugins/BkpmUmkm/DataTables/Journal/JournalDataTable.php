<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Journal;

use Illuminate\Support\Facades\DB;
use Plugins\BkpmUmkm\Models\JournalModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JournalDataTable extends DataTable
{
    protected $dataTableID = 'journalDatatable';        
    protected $viewed = false;    
    protected $company_id = '';

    public function __construct()
    {        
        $this->company_id = request()->get('company_id');                
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
            ->editColumn('activity_date', function($q){
                $formatDate = formatDate($q->activity_date);
                $html = $formatDate;
                return $html;
            })          
            ->rawColumns(['journal_task'])    
            ->rawColumns(['jurnal'])            
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Plugins\BkpmUmkm\Models\JournalModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JournalModel $model)
    {               
        $model = DB::table('journal_activity')
            ->leftJoin('journal_task', 'journal_activity.journal_task_id', '=', 'journal_task.id')            
            ->get();

        if (!empty($this->company_id)){
            $model = DB::table('journal_activity')
            ->leftJoin('journal_task', 'journal_activity.journal_task_id', '=', 'journal_task.id')            
            ->where('company_id', $this->company_id)->orderBy('activity_date', 'asc')
            ->get();
        }

        return $model;
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

        $script = '';

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
                Column::make('activity_date')->title('Tanggal Journal')->orderable(false),
                Column::make('journal_task')->title('Journal Task')->orderable(false),
                Column::make('jurnal')->title('Journal')->orderable(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'journal_' . date('YmdHis');
    }
}
