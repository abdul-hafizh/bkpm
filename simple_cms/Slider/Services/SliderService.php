<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 09/05/18
 * Time: 1:42
 */

namespace SimpleCMS\Slider\Services;


use SimpleCMS\Slider\Models\SliderModel;

class SliderService
{
    public static function save_update($request)
    {
        \DB::beginTransaction();
        try{
            if ($request->get('sorter') && $request->get('sorter') != ''){
                foreach ($request->input('sorter') as $index => $val){
                    SliderModel::where('id',$val)->update(['position'=>$index]);
                }
                \DB::commit();
                return responseMessage(__('Saving Success.'));
            }else{
                $id = encrypt_decrypt(filter($request->input('id')), 2);
                $data = [
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'link' => trim($request->input('link')),
                    'target_link' => trim($request->input('target_link')),
                    'cover' => trim($request->input('cover')),
                    'status' => trim($request->input('status')),
                ];
                $sliders = SliderModel::updateOrCreate(['id'=>$id],$data);
                \DB::commit();
                return responseMessage(__('Saving Success.'),['redirect'=>route('simple_cms.slider.backend.edit',['id'=>encrypt_decrypt($sliders->id),'slug'=>\Str::slug($sliders->title,'-')])]);
            }
        }catch (\Exception $e){
            \DB::rollback();
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function restore_delete($request)
    {
        try{
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            if(!empty($id)) {
                SliderModel::withTrashed()->where('id',$id)->restore();
            }
            return responseMessage(__('Data restored.'));
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function soft_delete($request)
    {
        try{
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            if(!empty($id)) {
                SliderModel::where('id', $id)->delete();
            }
            return responseMessage(__('Data trashed.'));
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function force_delete($request)
    {
        try{
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            if(!empty($id)) {
                SliderModel::withTrashed()->where('id', $id)->forceDelete();
            }
            return responseMessage(__('Data deleted.'));
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

}
