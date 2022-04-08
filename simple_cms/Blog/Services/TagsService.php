<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 21/08/18
 * Time: 3:47
 */

namespace SimpleCMS\Blog\Services;

use SimpleCMS\Blog\Models\TagModel;
use SimpleCMS\Blog\Models\TagsPostsModel;

class TagsService
{
    public static function save_update($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $logProperties = [
            'attributes' => [],
            'old' => ($id ? TagModel::find($id)->first()->toArray(): [])
        ];
        $slug = \Str::slug(filter($request->input('name')),'-');
        $whereUpdate = ['slug' => $slug];
        if ($id){
            $whereUpdate = ['id' => $id];
        }
        $tag = TagModel::query()->updateOrCreate($whereUpdate,[
            'slug'=>$slug,
            'name' => filter($request->input('name'))
        ]);
        $logProperties['attributes'] = $tag->toArray();
        $message = 'Your '.($id ? 'edit' : 'add').' tag '.$tag->name;
        $activity_group = 'add';
        if (!empty($id)){
            $activity_group = 'edit';
        }
        activity_log(LOG_TAG, $activity_group, $message, $logProperties, $tag);
        return responseMessage($message . ' success', ['data' => $tag]);

    }

    public static function select2($request)
    {
        $term = strtolower(filter($request->input('term')));
        return TagModel::select('id', 'name as text', 'name')->where(\DB::raw('LOWER(name)'),'LIKE','%'.$term.'%')->limit(10)->get();
    }

    public static function restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        if(!empty($id) OR !is_null($id)) {
            $tag = TagModel::withTrashed()->where('id', $id)->first();
            activity_log(LOG_TAG, 'restore', 'Your restore tag ' . $tag->name ,[],$tag);
            $tag->restore();
        }
        return responseMessage('Restore success');
    }

    public static function soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        if(!empty($id) OR !is_null($id)) {
            $tag = TagModel::where('id', $id)->first();
            activity_log(LOG_TAG, 'soft_delete', 'Your trashed tag ' . $tag->name ,[],$tag);
            $tag->delete();
        }
        return responseMessage('Trashed success');
    }

    public static function force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        if(!empty($id) OR !is_null($id)) {
            $tag = TagModel::withTrashed()->where('id',$id)->first();
            activity_log(LOG_TAG, 'force_delete', 'Your permanent delete tag ' . $tag->name ,[],$tag);
            $tag->forceDelete();
        }
        return responseMessage('Permanent delete success');
    }

    /* FOR CHECKBOX IN MENU */
    public static function tpl_checkbox_menu($selected='')
    {
        $data = TagModel::orderBy('name','ASC')->cursor();
        return '<nav class="category_menu">'.self::tpl_loop_checkbox_menu($data,$selected).'</nav>';
    }
    public static function tpl_loop_checkbox_menu($data,$selected='')
    {
        $html = '<ul>';
        foreach ($data as $dt){
            $html .= '<li class="custom-control custom-checkbox"><input id="tag_'.$dt->id.'" type="checkbox" class="filled-in custom-control-input" name="tags[]" value=\''.json_encode(['label'=>$dt->name,'title'=>$dt->name,'url'=>route('simple_cms.blog.tag',['post_slug'=>$dt->slug]),'icon'=>'', 'classcss'=>'','target'=>'_self','type'=>'tag','status'=>1]).'\'> <label for="tag_'.$dt->id.'" class="hover custom-control-label">'.$dt->name.'</label></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}
