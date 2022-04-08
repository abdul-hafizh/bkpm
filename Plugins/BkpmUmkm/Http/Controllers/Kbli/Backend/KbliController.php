<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Kbli\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Kbli\KbliDataTable;
use Plugins\BkpmUmkm\Http\Requests\KbliImportRequest;
use Plugins\BkpmUmkm\Http\Requests\KbliSaveUpdateRequest;
use Plugins\BkpmUmkm\Models\KbliModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KbliController extends Controller
{
    protected $config;
    protected $identifier;
    protected $kbliService;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->kbliService = app(\Plugins\BkpmUmkm\Services\KbliService::class);
    }

    public function index(KbliDataTable $KbliDataTable)
    {
        $params['title']        = trans('label.index_kbli');
        return $KbliDataTable->render($this->identifier . '::kbli.backend.index', $params);
    }

    public function add(Request $request)
    {
        $params['kbli']      = new KbliModel();
        $params['title']        = trans('label.add_new_kbli');
        $params['parent_kbli']  = KbliModel::orderBy('name')->whereNull('parent_code')->cursor();
        return view( $this->identifier . '::kbli.backend.add_edit')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['kbli']      = KbliModel::where('id', $id)->first();
        if (!$params['kbli']){
            return abort(404);
        }
        $params['title']        = trans('label.edit_kbli');
        $params['parent_kbli']  = KbliModel::orderBy('name')->whereNull('parent_code')->cursor();
        return view( $this->identifier . '::kbli.backend.add_edit')->with($params);
    }

    public function save_update(KbliSaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->kbliService->save_update($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->kbliService->restore($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->kbliService->soft_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->kbliService->force_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function import(KbliImportRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->kbliService->import($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
}
