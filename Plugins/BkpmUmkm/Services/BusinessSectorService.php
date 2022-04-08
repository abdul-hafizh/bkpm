<?php
namespace Plugins\BkpmUmkm\Services;

use Plugins\BkpmUmkm\Models\BusinessSectorModel;

class BusinessSectorService
{

    public function save_update($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $logProperties = [
            'attributes' => [],
            'old' => ($id ? BusinessSectorModel::find($id)->first()->toArray(): [])
        ];
        $name = filter($request->input('name'));
        $slug = \Str::slug($name,'-');
        $slug = $this->generateSlug($id, $slug);
        $data = [
            'slug' => $slug,
            'name' => $name
        ];
        $business_sector = BusinessSectorModel::query()->updateOrCreate(['id'=>$id],$data);
        $message = 'Your '.($id ? 'edit' : 'add').' '.trans('label.index_business_sector').': '.$business_sector->name;
        $logProperties['attributes'] = $business_sector->toArray();
        $activity_group = 'add';
        if (!empty($id)){
            $activity_group = 'edit';
        }
        activity_log("LOG_BUSINESS_SECTOR", $activity_group, $message, $logProperties, $business_sector);

        $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.business_sector.index')];
        return responseMessage($message . ' success', $returnData);
    }

    public function restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $business_sector = BusinessSectorModel::withTrashed()->where('id', $id)->first();
        if($business_sector) {
            activity_log("LOG_BUSINESS_SECTOR", 'restore', 'Your restore '.trans('label.index_business_sector').': ' . $business_sector->name ,[],$business_sector);
            $business_sector->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $business_sector = BusinessSectorModel::where('id', $id)->first();
        if($business_sector) {
            activity_log("LOG_BUSINESS_SECTOR", 'soft_delete', 'Your trashed '.trans('label.index_business_sector').': ' . $business_sector->name ,[],$business_sector);
            $business_sector->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $business_sector = BusinessSectorModel::withTrashed()->where('id', $id)->first();
        if($business_sector) {
            activity_log("LOG_BUSINESS_SECTOR", 'force_delete', 'Your permanent delete '.trans('label.index_business_sector').': ' . $business_sector->name ,[],$business_sector);
            $business_sector->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }

    public function import($request)
    {
        \Excel::import(new \Plugins\BkpmUmkm\Imports\BusinessSectorImport(), $request->file('file'));
        return responseSuccess(responseMessage(trans('core::message.success.import')));
    }

    public function generateSlug($id, $slug, $count = 0, $original = '')
    {
        $check_slug = BusinessSectorModel::where('id', '<>', $id)->where('slug', $slug)->count();
        $original = (empty($original) ? $slug : $original);
        if ($check_slug) {
            $count += $check_slug;
            $slug = $original . ($count > 0 ? '-' . $count : '');
            return $this->generateSlug($id, $slug, $count, $original);
        }
        return $original . ($count > 0 ? '-' . $count : '');
    }

}
