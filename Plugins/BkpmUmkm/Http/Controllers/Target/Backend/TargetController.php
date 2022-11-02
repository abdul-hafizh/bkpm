<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Target\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Target\TargetDataTable;
use Plugins\BkpmUmkm\Http\Requests\TargetImportRequest;
use Plugins\BkpmUmkm\Http\Requests\TargetSaveUpdateRequest;
use Plugins\BkpmUmkm\Models\TargetModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TargetController extends Controller
{
    protected $config;
    protected $identifier;
    protected $targetService;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->targetService = app(\Plugins\BkpmUmkm\Services\TargetService::class);
    }

    public function index(TargetDataTable $TargetDataTable)
    {
        $params['title']        = "Target";
        return $TargetDataTable->render($this->identifier . '::target.backend.index', $params);
    }

    public function add(Request $request)
    {
        $params['target']      = new TargetModel();
        $params['title']        = "Add New Target";
        return view( $this->identifier . '::target.backend.add_edit')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['target']      = TargetModel::where('id', $id)->first();
        if (!$params['target']){
            return abort(404);
        }
        $params['title']        = "Edit Target";
        return view( $this->identifier . '::target.backend.add_edit')->with($params);
    }

    public function save_update(TargetSaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->targetService->save_update($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->targetService->restore($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->targetService->soft_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->targetService->force_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function import(TargetImportRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->targetService->import($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
}
