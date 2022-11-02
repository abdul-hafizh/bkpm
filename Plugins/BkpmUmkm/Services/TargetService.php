<?php
namespace Plugins\BkpmUmkm\Services;

use Plugins\BkpmUmkm\Models\TargetModel;

class TargetService
{
    public function save_update($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $logProperties = [
            'attributes' => [],
            'old' => ($id ? TargetModel::find($id)->first()->toArray(): [])
        ];

        $data = [
            'target_UB' => filter($request->input('target_UB')),
            'target_umkm' => filter($request->input('target_umkm')),
            'target_value' => filter($request->input('target_value')),
            'tahun' => filter($request->input('tahun'))
        ];

        $target = TargetModel::query()->updateOrCreate(['id'=>$id],$data);
        $message = 'Your '.($id ? 'edit' : 'add').' Target : '.$target->tahun;
        $logProperties['attributes'] = $target->toArray();
        $activity_group = 'add';
        if (!empty($id)){
            $activity_group = 'edit';
        }
        activity_log("LOG_target", $activity_group, $message, $logProperties, $target);

        $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.target.index')];
        return responseMessage($message . ' success', $returnData);
    }

    public function restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $target = TargetModel::withTrashed()->where('id', $id)->first();
        if($target) {
            activity_log("LOG_target", 'restore', 'Your restore Target : ' . $target->tahun ,[],$target);
            $target->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $target = TargetModel::where('id', $id)->first();
        if($target) {
            activity_log("LOG_target", 'soft_delete', 'Your trashed Target : ' . $target->tahun ,[],$target);
            $target->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $target = TargetModel::withTrashed()->where('id', $id)->first();
        if($target) {
            activity_log("LOG_target", 'force_delete', 'Your permanent delete Target : ' . $target->tahun ,[],$target);
            $target->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }
    public function import($request)
    {
        \Excel::import(new \Plugins\BkpmUmkm\Imports\TargetImport(), $request->file('file'));
        return responseSuccess(responseMessage(trans('core::message.success.import')));
    }

}
