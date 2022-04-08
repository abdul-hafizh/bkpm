<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 9:48 PM ---------
 */

namespace SimpleCMS\ActivityLog\Http\Controllers;


use SimpleCMS\ActivityLog\DataTables\ActivityLogAllDataTable;
use SimpleCMS\ActivityLog\DataTables\ActivityLogDataTable;
use SimpleCMS\Core\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function index(ActivityLogDataTable $dataTable)
    {
        return $dataTable->render('activitylog::index');
    }

    public function modal(ActivityLogDataTable $dataTable)
    {
        return $dataTable->render('activitylog::modal');
    }

    public function all(ActivityLogAllDataTable $dataTable)
    {
        return $dataTable->render('activitylog::all');
    }
}
