<?php
namespace Plugins\BkpmUmkm\Services;

use Plugins\BkpmUmkm\Models\KbliModel;

class KbliService
{
    public function save_update($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $logProperties = [
            'attributes' => [],
            'old' => ($id ? KbliModel::find($id)->first()->toArray(): [])
        ];
        $data = [
            'code' => filter($request->input('code')),
            'name' => filter($request->input('name')),
            'description' => filter($request->input('description'))
        ];
        if (filter($request->input('parent_code'))){
            $data['parent_code'] = filter($request->input('parent_code'));
        }
        $kbli = KbliModel::query()->updateOrCreate(['id'=>$id],$data);
        $message = 'Your '.($id ? 'edit' : 'add').' '.trans('label.index_kbli').': '.$kbli->name;
        $logProperties['attributes'] = $kbli->toArray();
        $activity_group = 'add';
        if (!empty($id)){
            $activity_group = 'edit';
        }
        activity_log("LOG_KBLI", $activity_group, $message, $logProperties, $kbli);

        $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.kbli.index')];
        return responseMessage($message . ' success', $returnData);
    }

    public function restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $kbli = KbliModel::withTrashed()->where('id', $id)->first();
        if($kbli) {
            activity_log("LOG_KBLI", 'restore', 'Your restore '.trans('label.index_kbli').': ' . $kbli->name ,[],$kbli);
            $kbli->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $kbli = KbliModel::where('id', $id)->first();
        if($kbli) {
            activity_log("LOG_KBLI", 'soft_delete', 'Your trashed '.trans('label.index_kbli').': ' . $kbli->name ,[],$kbli);
            $kbli->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $kbli = KbliModel::withTrashed()->where('id', $id)->first();
        if($kbli) {
            activity_log("LOG_KBLI", 'force_delete', 'Your permanent delete '.trans('label.index_kbli').': ' . $kbli->name ,[],$kbli);
            $kbli->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }
    public function import($request)
    {
        \Excel::import(new \Plugins\BkpmUmkm\Imports\KbliImport(), $request->file('file'));
        return responseSuccess(responseMessage(trans('core::message.success.import')));
    }

    public function generateSlug($id, $slug, $count = 0, $original = '')
    {
        $check_slug = KbliModel::where('id', '<>', $id)->where('slug', $slug)->count();
        $original = (empty($original) ? $slug : $original);
        if ($check_slug) {
            $count += $check_slug;
            $slug = $original . ($count > 0 ? '-' . $count : '');
            return $this->generateSlug($id, $slug, $count, $original);
        }
        return $original . ($count > 0 ? '-' . $count : '');
    }

}
