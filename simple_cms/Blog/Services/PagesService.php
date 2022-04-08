<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 09/05/18
 * Time: 1:42
 */

namespace SimpleCMS\Blog\Services;

use SimpleCMS\Blog\Models\PostModel;

class PagesService
{
    public static function save_update($request)
    {
        \DB::beginTransaction();
        $preview = ($request->has('preview') ? filter_var($request->input('preview'), FILTER_VALIDATE_BOOLEAN) : false);
        $has_id = ($request->has('has_id') ? filter_var($request->input('has_id'), FILTER_VALIDATE_BOOLEAN) : true);
        $update = false;
        try{
            $id = encrypt_decrypt($request->input('id'), 2);

            $logProperties = [
                'attributes' => [],
                'old' => []
            ];

            if (!empty($id)){
                $update = true;
            }

            $temp_page = PostModel::where('id', $id);

            $get_property = $temp_page;

            $slug = \Str::slug(filter($request->input('slug')), '-');
            $slug = generateSlug($id, $slug);

            if ($update){
                $logProperties['old'] = $get_property->with(['user'])->first()->toArray();
            }

            $is_have = $temp_page->first();

            $data_pages = [
                'slug' => $slug,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'description' => $request->input('description'),
                'thumb_image' => str_replace(['http://', 'https://'], '//', filter($request->input('thumb_image'))),
                'type' => filter($request->input('type')),
                'format' => (filter($request->input('format')) != '' ? filter($request->input('format')) : 'default' ),
                'status' => filter($request->input('status')),
                'full_page' => ($request->has('full_page') ? (int)$request->input('full_page') : 0),
                'created_at' => date('Y-m-d H:i:s', strtotime(filter($request->input('created_at')).':00'))
            ];

            if ( !$has_id && $preview )
            {
                $data_pages['status'] = 'draft';
            }
            if (!$is_have OR ($is_have && $is_have->user_id == auth()->user()->id)){
                $data_pages['user_id'] = auth()->user()->id;
            }
            $pages = PostModel::query()->updateOrCreate(['id' => $id], $data_pages);
            \DB::commit();
            $logProperties['attributes'] = $pages->with(['user'])->first()->toArray();
            $activity_group = 'add';
            if ($update){
                $activity_group = 'edit';
            }
            activity_log(LOG_PAGE, $activity_group, 'Your ' . ($update ? 'edit':'add') . ' page <b>'.$pages->title.'</b>', $logProperties, $pages);
            return responseMessage(__('core::message.success.save'), [
                'redirect' => route('simple_cms.blog.backend.page.edit', ['post_slug' => $pages->slug]),
                'link_preview' => route('simple_cms.blog.backend.page.preview', ['post_slug' => $pages->slug])
            ]);
        }catch (\Exception $e){
            \DB::rollback();
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public static function change_status($request)
    {
        $parse_change_status = encrypt_decrypt(trim($request->get('change_status')), 2);
        $parse_change_status = explode('|', $parse_change_status);
        $post = tap(PostModel::find($parse_change_status[0]))->update([
            'status' => $parse_change_status[1]
        ]);
        activity_log(LOG_PAGE, 'edit', 'Your change status to: <b>' . ucwords($parse_change_status[1]) . '</b>. <br/>For page <b>'.$post->title.'</b>', [], $post);
        return responseMessage('Change status success.');
    }

    public static function restore($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        if(!empty($id) OR !is_null($id)) {
            $page = PostModel::withTrashed()->where('id', $id)->first();
            activity_log(LOG_PAGE, 'restore', 'Your restore '.strtolower($page->type).' <strong>' . $page->title . '</strong>',[],$page);
            $page->restore();
        }
        return responseMessage('Restore success');
    }

    public static function soft_delete($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        if(!empty($id) OR !is_null($id)) {
            $page = PostModel::where('id', $id)->first();
            activity_log(LOG_PAGE, 'soft_delete', 'Your trashed '.strtolower($page->type).' <strong>' . $page->title . '</strong>',[],$page);
            $page->delete();
        }
        return responseMessage('Trashed success');
    }

    public static function force_delete($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        if(!empty($id) OR !is_null($id)) {
            $page = PostModel::withTrashed()->where('id', $id)->first();
            activity_log(LOG_PAGE, 'force_delete', 'Your permanent delete '.strtolower($page->type).' <strong>' . $page->title . '</strong>',[],$page);
            $page->forceDelete();
        }
        return responseMessage('Permanent delete success');
    }
}
