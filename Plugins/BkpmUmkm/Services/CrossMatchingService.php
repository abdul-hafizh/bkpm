<?php

namespace Plugins\BkpmUmkm\Services;


use Carbon\Carbon;
use Plugins\BkpmUmkm\Models\KemitraanModel;

class CrossMatchingService
{
    public function picked()
    {
        $logProperties = [
            'attributes' => [],
            'old' => []
        ];

        $company    = request()->route()->parameter('company');
        $company_id = encrypt_decrypt(request()->route()->parameter('company_id'), 2);
        $target_to  = encrypt_decrypt(request()->input('target_to'), 2);
        $target_id  = encrypt_decrypt(request()->input('target_id'), 2);
        $reversed   = ($target_to == CATEGORY_COMPANY ? CATEGORY_UMKM : CATEGORY_COMPANY);
        $year = Carbon::now()->format('Y');

        /* Check if already picked */
        $check = KemitraanModel::where(["{$reversed}_id" => $company_id, "{$target_to}_id" => $target_id, "{$target_to}_status" => "bersedia"])->whereYear('created_at', $year)->first();
        if ($check){
            return responseError(responseMessage(__('message.cross_matching_already_picked')));
        }
        $kemitraan = KemitraanModel::create([
            "{$company}_id"         => $company_id,
            "{$company}_status"     => "bersedia",
            "{$target_to}_id"       => $target_id,
            "{$target_to}_status"   => "bersedia",
            "status"                => "bersedia"
        ]);
        $logProperties['attributes'] = $kemitraan->toArray();
        $activity_group = 'add';
        activity_log("LOG_CROSS_MATCHING", $activity_group, __("message.cross_matching_added"), $logProperties, $kemitraan);
        return responseSuccess(responseMessage(__('message.cross_matching_picked_success')));
    }

    public function change_status()
    {
        $company    = request()->route()->parameter('company');
        $company_id = encrypt_decrypt(request()->route()->parameter('company_id'), 2);
        $id         = encrypt_decrypt(request()->input('id'), 2);
        $target_to  = encrypt_decrypt(request()->input('target_to'), 2);
        $target_id  = encrypt_decrypt(request()->input('target_id'), 2);
        $status     = encrypt_decrypt(request()->input('status'), 2);
        $description= filter(request()->input('description'));


        $kemitraan = KemitraanModel::where("id", $id)->first();
        if (!$kemitraan){
            return responseError(responseMessage(__('message.data_not_found')));
        }
        $toArray = $kemitraan;
        $logProperties = [
            'attributes' => [],
            'old' => [$toArray->toArray()]
        ];
        $kemitraan->{"{$company}_status"}   = 'bersedia';
        $kemitraan->status                  = ($kemitraan->{"{$company}_status"} != $status ? 'tidak_bersedia' : 'bersedia');
        $kemitraan->{"{$target_to}_status"} = $status;
        $kemitraan->{"{$target_to}_status_description"} = $description;

        $kemitraan->save();
        $logProperties['attributes'] = $kemitraan->toArray();
        $activity_group = "change_status.{$kemitraan->status}";
        $message = __("message.cross_matching_change_status") . " : " . __("label.cross_matching_status_{$status}");
        activity_log("LOG_CROSS_MATCHING", $activity_group, $message, $logProperties, $kemitraan);
        return responseSuccess(responseMessage(__('message.cross_matching_change_status_success')));
    }

    public function force_delete()
    {
        $company    = request()->route()->parameter('company');
        $company_id = encrypt_decrypt(request()->route()->parameter('company_id'), 2);
        $id         = encrypt_decrypt(request()->input('id'), 2);
        $kemitraan = KemitraanModel::where("id", $id)->first();
        if (!$kemitraan){
            return responseError(responseMessage(__('message.data_not_found')));
        }
        $kemitraan->forceDelete();
        return responseSuccess(responseMessage(__('message.cross_matching_force_delete_success')));
    }
}
