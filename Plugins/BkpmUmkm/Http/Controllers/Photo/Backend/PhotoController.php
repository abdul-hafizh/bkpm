<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Photo\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Photo\PhotoDataTable;
use Plugins\BkpmUmkm\Models\PhotoModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PhotoController extends Controller
{
    protected $config;
    protected $identifier;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
    }

    public function index(PhotoDataTable $PhotoDataTable)
    {
        $params['title'] = 'Data Photo Survey';
        $inModal = request()->get('in-modal');
        $view = "{$this->identifier}::modal_photo.datatable";
        return $PhotoDataTable->render($view, $params);
    }
}
