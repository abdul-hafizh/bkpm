<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Umkm\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Umkm\UmkmObservasiMassiveDataTable;
use Plugins\BkpmUmkm\Http\Requests\UmkmImportRequest;
use Plugins\BkpmUmkm\Http\Requests\UmkmObservasiMassiveSaveUpdateRequest;
use Plugins\BkpmUmkm\Models\UmkmMassiveModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UmkmObservasiMassiveController extends Controller
{
    protected $config;
    protected $identifier;
    protected $umkmMassiveService;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->umkmMassiveService = app(\Plugins\BkpmUmkm\Services\UmkmMassiveService::class);
    }

    public function index(UmkmObservasiMassiveDataTable $umkmDataTable)
    {
        $params['title'] = trans('label.umkm_observasi_massive');
        return $umkmDataTable->render("{$this->identifier}::umkm.backend.massive.index", $params);
    }

    public function add(Request $request)
    {
        $params['umkm']         = new UmkmMassiveModel();
        $params['title']        = trans('label.add_new_umkm_observasi_massive');
        return view( $this->identifier . '::umkm.backend.massive.add_edit')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['umkm']      = UmkmMassiveModel::where(['id' => $id])->with(['kbli'])->first();
        if (!$params['umkm']){
            return abort(404);
        }
        $params['title']        = trans('label.edit_umkm_observasi_massive');
        return view( $this->identifier . '::umkm.backend.massive.add_edit')->with($params);
    }

    public function detail(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['umkm']      = UmkmMassiveModel::where(['id' => $id])->first();
        if (!$params['umkm']){
            return abort(404);
        }
        $params['title']        = trans('label.umkm_observasi_massive') . ": {$params['umkm']->name}";
        $params['auth_check']   = auth()->check();
        $params['template']     = view("{$this->identifier}::umkm.sections.massive.detail")->with($params)->render();
        if ($request->ajax()){
            return view( $this->identifier . '::umkm.sections.massive.modal_detail')->with($params)->render();
        }
        return view( $this->identifier . '::umkm.backend.massive.detail')->with($params);
    }

    public function save_update(UmkmObservasiMassiveSaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmMassiveService->observasi_massive_save_update($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmMassiveService->observasi_massive_restore($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmMassiveService->observasi_massive_soft_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmMassiveService->observasi_massive_force_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function import(UmkmImportRequest $request)
    {
        if($request->ajax()){
            return $this->umkmMassiveService->observasi_massive_import($request);
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
}
