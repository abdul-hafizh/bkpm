<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 22/03/18
 * Time: 6:33
 */

namespace SimpleCMS\Core\Services;


class CoreService
{
    public static function upload_file($request,$path_upload,$name_input='files',$name_file='')
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

            $create_dir = self::createDirIfNotExists($path_upload);

            if($files->move($path_upload, $file_name)) {
                $path_upload = str_replace(public_path('uploads') . '/','',$path_upload);
                $file = url('uploads/'.$path_upload.'/'.$file_name);
                $file = str_replace(url('/').'/','',$file);
                return $file;
            }
            throw new \ErrorException('Upload file gagal.');
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function createDirIfNotExists($dirs)
    {
        try{
            if( ! is_dir($dirs) ) {
                mkdir($dirs, 0755, true);
            }else {
                $files = array_diff(scandir($dirs), array('.', '..'));
                foreach ($files as $file) {
                    if (!file_exists("$dirs/$file")) {
                        mkdir("$dirs/$file", 0755, true);
                    }
                }
            }
            return true;
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function send_mail($template,$data_email)
    {
        try{
            \Mail::send($template,$data_email, function ($message) use($data_email){
                    $message->from(config('mail.from.address'), config('mail.from.name'))->to($data_email['mail_to'],$data_email['mail_to_name'])->subject($data_email['subject']);
                    if(isset($data_email['cc']) && $data_email['cc']!=''){
                        $message->cc($data_email['cc']);
                    }
                });
            return true;
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }
}
