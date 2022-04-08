<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 22/03/18
 * Time: 6:33
 */

namespace SimpleCMS\Core\Services;


use Illuminate\Support\Facades\Artisan;
use SimpleCMS\Core\Models\SettingModel;

class SettingService
{
    public static function save_update($request)
    {
        \DB::beginTransaction();
        try{
            foreach ($request->input('settings') as $index => $value){
                if (is_array($value)){
                    $value = serializeCustom($value);
                }
                SettingModel::query()->updateOrCreate(['key'=>$index],['key' => $index, 'option'=>$value]);
                switch ($index){
                    case 'theme_active':
                        setEnvironment('APP_THEME', $value);
                        if (!is_dir(public_path("themes/{$value}"))) {
                            Artisan::call("simple_cms:theme:publish {$value}");
                        }
                        break;
                }
                activity_log(LOG_SETTING, 'edit','Change setting for key <b>'.$index.'</b>',[],auth()->user());
                clearCacheSetting($index);
            }
            \DB::commit();
            return responseMessage('Save setting success.');
        }catch (\Exception $e){
            \DB::rollback();
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public static function store_file($request)
    {

    }

}
