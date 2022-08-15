<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace Plugins\BkpmUmkm\DataTables\Photo;

use Illuminate\Support\Facades\DB;
use Plugins\BkpmUmkm\Models\PhotoModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PhotoDataTable extends DataTable
{
    protected $dataTableID = 'photoDatatable';        
    protected $viewed = false;    
    protected $survey_id = '';

    public function __construct()
    {        
        $this->survey_id = request()->get('survey_id');                
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
            ->editColumn('photo', function($q){
                if ($q->foto1) {
                    $html = '<div class="row">';
                    $html .= '<a href="' . asset($q->foto1) . '" target="_blank" class="d-block mb-4 m-3 h-100">';
                    $html .= '<img class="img-fluid img-thumbnail" width="200px" height="200px" src="' . view_asset($q->foto1) . '">';
                    $html .= '</a>';
                    if (!empty($q->foto2)){
                        $html .= '<a href="' . asset($q->foto2) . '" target="_blank" class="d-block mb-4 m-3 h-100">';
                        $html .= '<img class="img-fluid img-thumbnail" width="200px" height="200px" src="' . view_asset($q->foto2) . '">';
                        $html .= '</a>';
                    }
                    if (!empty($q->foto3)){
                        $html .= '<a href="' . asset($q->foto3) . '" target="_blank" class="d-block mb-4 m-3 h-100">';
                        $html .= '<img class="img-fluid img-thumbnail" width="200px" height="200px" src="' . view_asset($q->foto3) . '">';
                        $html .= '</a>';
                    }
                    $html .= '</div>';
                    return $html;
                }          
                return '-';
            })
            ->rawColumns(['photo'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Plugins\BkpmUmkm\Models\PhotoModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PhotoModel $model)
    {           
        $model = DB::table('vw_photo_survey')
        ->where('survey_id', $this->survey_id)
        ->get();

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
            Column::make('photo')->title('Foto Survey')->addClass('text-center')->orderable(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'photo_' . date('YmdHis');
    }
}
