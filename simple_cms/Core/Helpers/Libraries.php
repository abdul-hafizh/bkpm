<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/23/20, 8:09 AM ---------
 */

if( ! function_exists('library_bootstrap') )
{
    /*
     * @param string css|less|scss|js $lib
     * @param boolean $asset
     * @param string font-awesome|flag|material-design|simple-line|themify $lib
     * @param string 5.31|5.12.1 $version
     * @return string
     * */
    function library_bootstrap($lib='css', $asset = false, $version = '')
    {
        if (empty($version)) {
            $version = app('config')->get('core.bootstrap_version');
        }
        $style  = 'module_style';
        $script = 'module_script';
        if ($asset)
        {
            $style  = 'module_asset';
            $script = 'module_asset';
        }
        $libs = [
            'css'   => call_user_func_array($style, ['core', 'plugins/bootstrap/'.$version.'/css/bootstrap.min.css']),
            'less'  => '',
            'scss'  => '',
            'js'    => call_user_func_array($script, ['core', 'plugins/bootstrap/'.$version.'/js/bootstrap.bundle.min.js'])
        ];
        return $libs[$lib];
    }
}

if( ! function_exists('library_datatables') )
{
    function library_datatables($lib, $bootstrap = '4', $buttonsServerSide = true){
        $dataTablesBootstrap4 = 'plugins/DataTables-bootstrap4/';
        $dataTablesBootstrap3 = 'plugins/DataTables-bootstrap3/';
        $libs =[
            /* DataTables Bootstrap 4 */
            '4' => [
                'css' => module_style('core',$dataTablesBootstrap4 . 'DataTables-1.10.20/css/dataTables.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'Buttons-1.6.1/css/buttons.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'ColReorder-1.5.2/css/colReorder.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'FixedColumns-3.3.0/css/fixedColumns.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'FixedHeader-3.1.6/css/fixedHeader.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'Responsive-2.2.3/css/responsive.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'RowGroup-1.1.1/css/rowGroup.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'RowReorder-1.2.6/css/rowReorder.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'Scroller-2.0.1/css/scroller.bootstrap4.min.css') .
                    module_style('core',$dataTablesBootstrap4 . 'SearchPanes-1.0.1/css/searchPanes.bootstrap4.min.css')
                ,

                'js'  => module_script('core', $dataTablesBootstrap4 . 'DataTables-1.10.20/js/jquery.dataTables.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'DataTables-1.10.20/js/dataTables.bootstrap4.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'Buttons-1.6.1/js/dataTables.buttons.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'Buttons-1.6.1/js/buttons.bootstrap4.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'ColReorder-1.5.2/js/dataTables.colReorder.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'FixedColumns-3.3.0/js/dataTables.fixedColumns.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'FixedHeader-3.1.6/js/dataTables.fixedHeader.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'Responsive-2.2.3/js/dataTables.responsive.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'Responsive-2.2.3/js/responsive.bootstrap4.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'RowGroup-1.1.1/js/dataTables.rowGroup.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'RowReorder-1.2.6/js/dataTables.rowReorder.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'Scroller-2.0.1/js/dataTables.scroller.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap4 . 'SearchPanes-1.0.1/js/dataTables.searchPanes.min.js', ['type' => 'text/javascript'])
            ],

            /* DataTables Bootstrap 3 */
            '3' => [
                'css' => module_style('core',$dataTablesBootstrap3 . 'DataTables-1.10.20/css/dataTables.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'Buttons-1.6.1/css/buttons.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'ColReorder-1.5.2/css/colReorder.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'FixedColumns-3.3.0/css/fixedColumns.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'FixedHeader-3.1.6/css/fixedHeader.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'Responsive-2.2.3/css/responsive.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'RowGroup-1.1.1/css/rowGroup.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'RowReorder-1.2.6/css/rowReorder.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'Scroller-2.0.1/css/scroller.bootstrap.min.css') .
                    module_style('core',$dataTablesBootstrap3 . 'SearchPanes-1.0.1/css/searchPanes.bootstrap.min.css')
                ,

                'js'  => module_script('core', $dataTablesBootstrap3 . 'DataTables-1.10.20/js/jquery.dataTables.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'DataTables-1.10.20/js/dataTables.bootstrap.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'Buttons-1.6.1/js/dataTables.buttons.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'Buttons-1.6.1/js/buttons.bootstrap.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'ColReorder-1.5.2/js/dataTables.colReorder.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'FixedColumns-3.3.0/js/dataTables.fixedColumns.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'FixedHeader-3.1.6/js/dataTables.fixedHeader.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'Responsive-2.2.3/js/dataTables.responsive.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'Responsive-2.2.3/js/responsive.bootstrap.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'RowGroup-1.1.1/js/dataTables.rowGroup.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'RowReorder-1.2.6/js/dataTables.rowReorder.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'Scroller-2.0.1/js/dataTables.scroller.min.js', ['type' => 'text/javascript']) .
                    module_script('core', $dataTablesBootstrap3 . 'SearchPanes-1.0.1/js/dataTables.searchPanes.min.js', ['type' => 'text/javascript'])
            ],

        ];
        if ($buttonsServerSide === true) {
            $libs[$bootstrap]['js'] .= module_script('core', 'datatables/buttons.server-side.js', ['style' => 'text/javascript']);
        }

        return $libs[$bootstrap][$lib];
    }
}

if( ! function_exists('library_codemirror') )
{
    function library_codemirror($lib){
        $version = '5.52.0';

        $codemirror = [
            'css' => module_style('core', 'plugins/codemirror/'.$version.'/lib/codemirror.css').
                module_style('core', 'plugins/codemirror/'.$version.'/addon/dialog/dialog.css').
                module_style('core', 'plugins/codemirror/'.$version.'/addon/hint/show-hint.css').
                module_style('core', 'plugins/codemirror/'.$version.'/addon/scroll/simplescrollbars.css').
                module_style('core', 'plugins/codemirror/'.$version.'/theme/monokai.css'),

            'js'  => module_script('core', 'plugins/codemirror/'.$version.'/lib/codemirror.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/edit/closetag.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/search/search.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/edit/closebrackets.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/comment/comment.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/wrap/hardwrap.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/fold/foldcode.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/fold/brace-fold.js').
                module_script('core', 'plugins/codemirror/'.$version.'/keymap/sublime.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/scroll/simplescrollbars.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/hint/anyword-hint.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/hint/show-hint.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/hint/xml-hint.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/hint/html-hint.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/hint/javascript-hint.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/hint/css-hint.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/selection/active-line.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/selection/mark-selection.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/selection/selection-pointer.js').
                module_script('core', 'plugins/codemirror/'.$version.'/addon/edit/matchbrackets.js').
                module_script('core', 'plugins/codemirror/'.$version.'/mode/javascript/javascript.js').
                module_script('core', 'plugins/codemirror/'.$version.'/mode/css/css.js').
                module_script('core', 'plugins/codemirror/'.$version.'/mode/htmlmixed/htmlmixed.js').
                module_script('core', 'plugins/codemirror/'.$version.'/mode/clike/clike.js').
                module_script('core', 'plugins/codemirror/'.$version.'/mode/php/php.js').
                module_script('core', 'plugins/codemirror/'.$version.'/mode/xml/xml.js')
        ];

        return $codemirror[$lib];
    }
}

if( ! function_exists('library_select2'))
{
    function library_select2($lib)
    {
        $libs = [
            'css' => module_style('core','plugins/select2/css/select2.min.css') . module_style('core','plugins/select2/css/select2-bootstrap4.min.css'),
            'js' => module_script('core','plugins/select2/js/select2.full.min.js') . module_script('core', 'js/event-select2.js')
        ];
        return $libs[$lib];
    }
}

if( ! function_exists('library_datepicker'))
{
    function library_datepicker($lib)
    {
        $libs = [
            'css' => module_style('core','plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') . module_style('core','plugins/bootstrap-daterangepicker/daterangepicker.css'),
            'js' => module_script('core','plugins/moment/moment.js') . module_script('core','plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') . module_script('core','plugins/bootstrap-daterangepicker/daterangepicker.js') . module_script('core', 'js/event-datepicker.js')
        ];
        return $libs[$lib];
    }
}

if( ! function_exists('library_icons') )
{
    /*
     * @param string css|less|scss|js $lib
     * @param boolean $asset
     * @param string font-awesome|flag|material-design|simple-line|themify $lib
     * @param string 5.31|5.12.1 $version
     * @return string
     * */
    function library_icons($lib='css', $asset = false, $font = 'font-awesome', $version = '5.12.1')
    {
        $style  = 'module_style';
        $script = 'module_script';
        if ($asset)
        {
            $style  = 'module_asset';
            $script = 'module_asset';
        }
        $libs = [
            'css'   => '',
            'less'  => '',
            'scss'  => '',
            'js'    => ''
        ];
        switch ($font)
        {
            case 'flag':
                $libs['css'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/flag-icon.min.css']);
                $libs['less'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/less/flag-icon.less']);
                $libs['scss'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/scss/flag-icon.scss']);
                break;
            case 'font-awesome':
                $libs['css'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/all.min.css']);
                $libs['less'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/less/fontawesome.less']);
                $libs['scss'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/scss/fontawesome.scss']);
                if ($version == '5.12.2'){
                    $libs['css'] .= call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/v4-shims.min.css']);
                    $libs['less'] .= call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/less/v4-shims.less']);
                    $libs['scss'] .= call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/scss/v4-shims.scss']);
                }
                break;
            case 'material-design':
                $libs['css'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/materialdesignicons.min.css']);
                $libs['scss'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/scss/materialdesignicons.scss']);
                break;
            case 'simple-line':
                $libs['css'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/simple-line-icons.css']);
                $libs['less'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/less/simple-line-icons.less']);
                $libs['scss'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/scss/simple-line-icons.scss']);
                break;
            case 'themify':
                $libs['css'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/themify-icons.min.css']);
                break;
            case 'line':
                $libs['css'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/LineIcons.css']);
                $libs['css'] .= call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/LineIconsEffect.css']);
                $libs['less'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/less/main.less']);
                $libs['scss'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/scss/main.scss']);
                break;
            case 'ionicons':
                $libs['css'] = call_user_func_array($style, ['core', 'icons/'.$font.'/'.$version.'/css/ionicons.min.css']);
                break;
        }
        return $libs[$lib];
    }
}

if( ! function_exists('library_leaflet') )
{
    /*
     * @param string css|js $lib
     * @param boolean $viewable
     * @param string 5.31|5.12.1 $version
     * @param boolean $leaflet_search_version
     * @return string
     * */
    function library_leaflet($lib='css', $viewable=false, $version = '1.6.0', $leaflet_search_version = '2.9.0')
    {
        $style  = 'module_style';
        $script = 'module_script';
        $libs['css'] = call_user_func_array($style, ['core', 'leaflet-map/css/init_map.css']).
                        call_user_func_array($style, ['core', 'plugins/leaflet-search/'.$leaflet_search_version.'/css/leaflet-search.min.css']).
                        call_user_func_array($style, ['core', 'plugins/leaflet/'.$version.'/leaflet.css']);

        $libs['js'] = call_user_func_array($script, ['core', 'plugins/leaflet/'.$version.'/leaflet.js']).
                        call_user_func_array($script, ['core', 'plugins/leaflet-search/'.$leaflet_search_version.'/js/leaflet-search.min.js']);
        if ($viewable){
            $libs['js'] .= call_user_func_array($script, ['core', 'leaflet-map/js/init_view_map.js']);
        }else{
            $libs['js'] .= call_user_func_array($script, ['core', 'leaflet-map/js/init_map.js']);
        }
        return $libs[$lib];
    }
}

if( ! function_exists('library_highcharts') )
{
    /*
     * @param string css|js $lib
     * @param string 8.2.0 $version
     * @return string
     * */
    function library_highcharts($lib='css', $version = '8.2.0')
    {
        $style  = 'module_style';
        $script = 'module_script';
        $libs['css'] = call_user_func_array($style, ['core', 'plugins/highcharts/'.$version.'/css/highcharts.css']);

        $libs['js'] = call_user_func_array($script, ['core', 'plugins/highcharts/'.$version.'/highcharts.js']).
            call_user_func_array($script, ['core', 'plugins/highcharts/'.$version.'/highcharts-more.js']).
            call_user_func_array($script, ['core', 'plugins/highcharts/'.$version.'/modules/map.js']).
            call_user_func_array($script, ['core', 'plugins/highcharts/'.$version.'/modules/exporting.js']);

        return $libs[$lib];
    }
}
