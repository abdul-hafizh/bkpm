<?php

namespace Plugins\BkpmUmkm\Services;


use Plugins\BkpmUmkm\Models\KemitraanModel;
use function GuzzleHttp\Psr7\str;

class KemitraanService
{
    public function save()
    {
        $logProperties = [
            'attributes' => [],
            'old' => []
        ];

        $kemitraan_id       = encrypt_decrypt(request()->route()->parameter('kemitraan_id'), 2);
        $sector  = filter(request()->input('sector'));
        $nominal_investasi  = filter(request()->input('nominal_investasi'));
        $nominal_investasi  = str_replace(['.', ','], '', $nominal_investasi);
        $date_kemitraan     = trim(request()->input('date_kemitraan'));
        // $date_kemitraan     = explode(' - ', $date_kemitraan);

        /* Check if already picked */
        $kemitraan = KemitraanModel::where('id', $kemitraan_id)->first();
        if (!$kemitraan){
            return responseError(responseMessage(__('message.data_not_found')));
        }
        $kemitraan->sector              = $sector;
        $kemitraan->nominal_investasi   = $nominal_investasi;
        $kemitraan->start_date          = str_replace('/', '-', $date_kemitraan);
        // $kemitraan->end_date            = str_replace('/', '-', $date_kemitraan[1]);
        $path_upload = 'companies/kemitraan/'.encrypt_decrypt($kemitraan->id);
        if (request()->file('file_kerjasama')){
            $file_kerjasama = $this->upload_file(request(), $path_upload, 'file_kerjasama');
            $kemitraan->file_kerjasama = $file_kerjasama;
            if (request()->input('file_kerjasama_old') && file_exists(public_path(trim(request()->input('file_kerjasama_old'))))){
                unlink(public_path(trim(request()->input('file_kerjasama_old'))));
            }
        }
        if (request()->file('file_kontrak')){
            $file_kontrak = $this->upload_file(request(), $path_upload, 'file_kontrak');
            $kemitraan->file_kontrak = $file_kontrak;
            if (request()->input('file_kontrak_old') && file_exists(public_path(trim(request()->input('file_kontrak_old'))))){
                unlink(public_path(trim(request()->input('file_kontrak_old'))));
            }
        }
        $kemitraan->save();

        $logProperties['attributes'] = $kemitraan->toArray();
        $activity_group = 'edit';
        activity_log("LOG_KEMITRAAN", $activity_group, __("message.kemitraan_edited"), $logProperties, $kemitraan);
        return responseSuccess(responseMessage(__('message.success')));
    }

    protected function upload_file($request, $path_upload, $name_input='files', $name_file='', $replace_url=true)
    {
        try{
            $files = $request->file($name_input);
            $extension = $files->getClientOriginalExtension();
            $ori_filename = $files->getClientOriginalName();
            $quick_random = str_random(8).date('His');
            if ($name_file!=''){
                $file_name = str_slug($name_file, '-') . '-' . $quick_random . '.' . $extension;
            }else {
                $file_name = str_slug(remove_extension($ori_filename), '-') . '-' . $quick_random . '.' . $extension;
            }
            $destination_upload = public_path($path_upload);
            $create_dir = \SimpleCMS\Core\Services\CoreService::createDirIfNotExists($destination_upload);

            if($files->move($destination_upload, $file_name)) {
                $file = url($path_upload . '/' . $file_name);
                $file = str_replace(url('/') . '/', '', $file);
                return $file;
            }
            throw new \ErrorException('Upload file '. $ori_filename .' gagal.');
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }
}
