<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Journal\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Journal\JournalDataTable;
use Plugins\BkpmUmkm\Models\JournalModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JournalController extends Controller
{
    protected $config;
    protected $identifier;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
    }

    public function index(JournalDataTable $JournalDataTable)
    {
        $params['title'] = 'Data Journal Task';
        $inModal = request()->get('in-modal');
        $view = "{$this->identifier}::modal_journal.datatable";
        return $JournalDataTable->render($view, $params);
    }
}
