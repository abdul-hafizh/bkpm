<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 09/05/18
 * Time: 1:42
 */

namespace SimpleCMS\Blog\Services;


use SimpleCMS\Blog\Models\CategoriesPostsModel;
use SimpleCMS\Blog\Models\PostModel;
use SimpleCMS\Blog\Models\TagModel;
use SimpleCMS\Blog\Models\TagsPostsModel;

class PostsService
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

            $temp_post = PostModel::where('id', $id);

            $get_property = $temp_post;

            $slug = \Str::slug(filter($request->input('slug')), '-');
            $slug = generateSlug($id, $slug);

            if ($update){
                $logProperties['old'] = $get_property->with(['user','categories','tags'])->first()->toArray();

                CategoriesPostsModel::where('post_id', $id)->forceDelete();
                TagsPostsModel::where('post_id', $id)->forceDelete();
            }

            $is_have = $temp_post->first();

            $data_posts = [
                'slug' => $slug,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'description' => $request->input('description'),
                'thumb_image' => str_replace(['http://', 'https://'], '//', filter($request->input('thumb_image'))),
                'type' => filter($request->input('type')),
                'status' => filter($request->input('status')),
                'comments' => ($request->has('comments')&&$request->input('comments')!='' ? filter($request->input('comments')) : '0'),
                'full_page' => ($request->has('full_page') ? (int)$request->input('full_page') : 0),
                'created_at' => date('Y-m-d H:i:s', strtotime(filter($request->input('created_at')).':00'))
            ];

            if (!$has_id && $preview )
            {
                $data_posts['status'] = 'draft';
            }
            if (!$is_have OR ($is_have && $is_have->user_id == auth()->user()->id)){
                $data_posts['user_id'] = auth()->user()->id;
            }
            if ($request->has('user_id') && !empty($request->input('user_id'))){
                $data_posts['user_id'] = filter($request->input('user_id'));
            }
            $posts = PostModel::query()->updateOrCreate(['id' => $id], $data_posts);
            $categories_posts = [];
            foreach ($request->input('categories') as $ctg) {
                $categories_posts[] = ['category_id' => $ctg, 'post_id' => $posts->id];
            }
            if (count($categories_posts)) {
                CategoriesPostsModel::insert($categories_posts);
            }

            if ($request->input('tags')) {
                $tags_posts = [];
                foreach ($request->input('tags') as $tg) {
                    $slug_tag = \Str::slug(filter($tg), '-');
                    $tag = TagModel::query()->updateOrCreate(['slug' => $slug_tag],[
                        'slug' => $slug_tag,
                        'name' => filter($tg)
                    ]);
                    $tags_posts[] = ['tag_id' => $tag->id, 'post_id' => $posts->id];
                }
                if (count($tags_posts)) {
                    TagsPostsModel::insert($tags_posts);
                }
            }
            \DB::commit();
            $logProperties['attributes'] = $posts->with(['user','categories','tags'])->first()->toArray();
            $activity_group = 'add';
            if ($update){
                $activity_group = 'edit';
            }
            activity_log(LOG_POST, $activity_group, 'Your ' . ($update ? 'edit':'add') . ' post <b>'.$posts->title.'</b>', $logProperties, $posts);
            return responseMessage(__('core::message.success.save'), [
                'redirect' => route('simple_cms.blog.backend.post.edit', ['post_slug' => $posts->slug]),
                'link_preview' => route('simple_cms.blog.backend.post.preview', ['post_slug' => $posts->slug])
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
        activity_log(LOG_POST, 'edit', 'Your change status to: <b>' . ucwords($parse_change_status[1]) . '</b>. <br/>For post <b>'.$post->title.'</b>', [], $post);
        return responseMessage('Change status success.');
    }

    public static function restore($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        if(!empty($id) OR !is_null($id)) {
            $post = PostModel::withTrashed()->where('id', $id)->first();
            activity_log('LOG_'.strtoupper($post->type), 'restore', 'Your restore '.strtolower($post->type).' <strong>' . $post->title . '</strong>',[],$post);
            $post->restore();
        }
        return responseMessage('Restore success');
    }

    public static function soft_delete($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        if(!empty($id) OR !is_null($id)) {
            $post = PostModel::where('id', $id)->first();
            activity_log('LOG_'.strtoupper($post->type), 'soft_delete', 'Your trashed '.strtolower($post->type).' <strong>' . $post->title . '</strong>',[],$post);
            $post->delete();
        }
        return responseMessage('Trashed success');
    }

    public static function force_delete($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        if(!empty($id) OR !is_null($id)) {
            $post = PostModel::withTrashed()->where('id', $id)->first();
            activity_log('LOG_'.strtoupper($post->type), 'force_delete', 'Your permanent delete '.strtolower($post->type).' <strong>' . $post->title . '</strong>',[],$post);
            $post->forceDelete();
            /*CategoriesPostsModel::where('id_posts', $id)->forceDelete();
            TagsPostsModel::where('id_post', $id)->forceDelete();*/
        }
        return responseMessage('Permanent delete success');
    }

    public static function active_inactive_comment($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        $message = '';
        if(!empty($id) OR !is_null($id)) {
            $post = PostModel::where(['id'=> $id])->update(['comments'=>$request->input('comments')]);
            $message = ((string)$request->input('comments') == '1' ? 'Enable':'Disable');
            activity_log('LOG_'.strtoupper($post->type), 'edit', 'Your '.strtolower($message).' comment '.strtolower($post->type).' <strong>' . $post->title . '</strong>',[],$post);
        }
        return responseMessage('Comment ' . $message);
    }

    public static function active_inactive_featured($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')),2);
        $message = '';
        if(!empty($id) OR !is_null($id)) {
            PostModel::where('id','<>',$id)->update(['featured'=>0]);
            $post = PostModel::where(['id'=>$id])->update(['featured'=>$request->input('featured')]);
            $message = ((string)$request->input('featured') == '1' ? 'Enable':'Disable');
            activity_log('LOG_'.strtoupper($post->type), 'edit', 'Your '.strtolower($message).' featured '.strtolower($post->type).' <strong>' . $post->title . '</strong>',[],$post);
        }
        return responseMessage('Featured ' . $message);
    }

    public static function generateSlug($id, $slug, $count = 0, $original = '')
    {
        $check_slug = PostModel::where('id', '<>', $id)->where('slug', $slug)->count();
        $original = (empty($original) ? $slug : $original);
        if ($check_slug) {
            $count += $check_slug;
            $slug = $original . ($count > 0 ? '-' . $count : '');
            return self::generateSlug($id, $slug, $count, $original);
        }
        return $original . ($count > 0 ? '-' . $count : '');
    }
}
