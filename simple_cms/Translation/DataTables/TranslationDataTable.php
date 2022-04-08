<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:28 AM ---------
 */

namespace SimpleCMS\Translation\DataTables;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use SimpleCMS\Translation\Models\Translation;
use SimpleCMS\Translation\Repositories\TranslationRepository;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TranslationDataTable extends DataTable
{
    protected $dataTableID = 'translationsDatatable';
    protected $trash = 'all';
    protected $translation;
    protected $available_locales;

    public function __construct()
    {
        $this->trash = (request()->has('trashed') && filter(request()->input('trashed')) != '' ? filter(request()->input('trashed')) : 'all');
        $this->translation = app(TranslationRepository::class);
        $this->available_locales = app('config')->get('translation.available_locales');
        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $results = datatables()
            ->of($query)
            ->addColumn('action', function ($q){
                $html = '<div class="btn-group btn-group-xs">';

                if (hasRoute('simple_cms.translation.backend.force_delete') && hasRoutePermission('simple_cms.translation.backend.force_delete')) {
                    $html .= '<a class="btn btn-xs btn-danger eventDataTableForceDelete" data-selecteddatatable="' . $this->dataTableID . '" href="javascript:void(0);" title="Permanent delete.!?" data-action="' . route('simple_cms.translation.backend.force_delete') . '" data-method="DELETE" data-value=\'' . json_encode(['code' => encrypt_decrypt($q->code)]) . '\'><i class="fas fa-trash"></i></a>';
                }

                $html .= '</div>';

                return $html;
            });
        $rawColumns = ['action'];
        foreach ($this->available_locales as $locale) {
            array_push($rawColumns, "language_{$locale}");
            $results->editColumn("language_{$locale}", function($q) use($locale) {
                $translation = $q->{"language_{$locale}"};//trans($q->code, [], $locale);
                if (hasRoutePermission('simple_cms.translation.backend.edit')){
                    $translation = ' <a href="javascript:void(0);" class="text-decoration-dashed show_modal_bs" data-action="'.route('simple_cms.translation.backend.edit', ['datatable' => true]).'" data-value=\''.json_encode(['locale' => $locale, 'code' => $q->code]).'\' title="Edit Translation: '.\Str::upper($locale).'">'.(!empty($translation) ? $translation : '<i>not_translated</i>').'</a>';
                }
                return $translation;
            });
        }
        return $results->rawColumns($rawColumns)
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \SimpleCMS\Translation\Models\Translation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Translation $model)
    {
        $selects = [\DB::raw('CONCAT(translator_translations.namespace, translator_translations.group, translator_translations.item) AS code,
`translator_translations`.`namespace`, 
`translator_translations`.`group`, 
`translator_translations`.`item`')];
        foreach ($this->available_locales as $locale) {
            array_push($selects, "lang_{$locale}.text AS language_{$locale}");
            $model = $model->leftJoin("translator_translations AS lang_{$locale}", function($q) use($locale){
                $q->on('translator_translations.namespace', '=', "lang_{$locale}.namespace")
                    ->on('translator_translations.group', '=', 'lang_'.$locale.'.group')
                    ->on('translator_translations.item', '=', 'lang_'.$locale.'.item')
                    ->where("lang_{$locale}.locale", '=', $locale);
            });
        }

        $model = $model->groupBy('code')->whereNotIn('translator_translations.group', ['translatable'])->select($selects);
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
            Button::make('create')->action('javascript:simple_cms.modal({title:"New Translation", url:"'.route('simple_cms.translation.backend.add').'"}, "bs")'),
            /*Button::make('crate')->raw([
                'data-action' => route('simple_cms.translation.backend.language.add')
            ]),*/
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')
        ];
        if ( !hasRoutePermission('simple_cms.translation.backend.add') ){
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
        $columns = [
//            Column::make('no_index', 'no_index')->title('No')
//                ->width('1%')->addClass('text-center')
//                ->orderable(false)->searchable(false),
            Column::make('namespace')->title('Namespace'),
            Column::make('group')->title('Group'),
            Column::make('code')->name('item')->title('Used/Key'),
        ];

        foreach ($this->available_locales as $locale) {
            $columns = array_merge($columns, [
                Column::make("language_{$locale}")->name("lang_{$locale}.text")->title(\Str::upper($locale))->orderable(true)->searchable(true)
            ]);
        }
        $columns = array_merge($columns, [
            Column::computed('action')->title('')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)->searchable(false)
                ->width('2%')
                ->addClass('text-center'),

        ]);
        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'translation_' . date('YmdHis');
    }
}
