<?php

namespace Plugins\BkpmUmkm\Http\Controllers\BusinessSector\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\BusinessSector\BusinessSectorDataTable;
use Plugins\BkpmUmkm\Http\Requests\BusinessSectorImportRequest;
use Plugins\BkpmUmkm\Http\Requests\BusinessSectorSaveUpdateRequest;
use Plugins\BkpmUmkm\Models\BusinessSectorModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BusinessSectorController extends Controller
{
    protected $config;
    protected $identifier;
    protected $businessSectorService;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->businessSectorService = app(\Plugins\BkpmUmkm\Services\BusinessSectorService::class);
    }

    public function index(BusinessSectorDataTable $businessSectorDataTable)
    {
        $params['title']        = trans('label.index_business_sector');
        return $businessSectorDataTable->render($this->identifier . '::business_sector.backend.index', $params);
    }

    public function add(Request $request)
    {
        $params['sector']      = new BusinessSectorModel();
        $params['title']        = trans('label.add_new_business_sector');
        return view( $this->identifier . '::business_sector.backend.add_edit')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['sector']      = BusinessSectorModel::where('id', $id)->first();
        if (!$params['sector']){
            return abort(404);
        }
        $params['title']        = trans('label.edit_business_sector');
        return view( $this->identifier . '::business_sector.backend.add_edit')->with($params);
    }

    public function save_update(BusinessSectorSaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->businessSectorService->save_update($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->businessSectorService->restore($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->businessSectorService->soft_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->businessSectorService->force_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function import(BusinessSectorImportRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->businessSectorService->import($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
}
