<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 09/05/18
 * Time: 1:42
 */

namespace SimpleCMS\Blog\Services;


use SimpleCMS\ACL\Models\User;
use SimpleCMS\Blog\Models\CategoriesPostsModel;
use SimpleCMS\Blog\Models\CategoryModel;

class CategoryService
{
    public static function save_update($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $logProperties = [
            'attributes' => [],
            'old' => ($id ? CategoryModel::find($id)->first()->toArray(): [])
        ];
        $slug = \Str::slug(filter($request->input('slug')),'-');
        $slug = self::generateSlug($id, $slug);
        $data = [
            'slug' => $slug,
            'name' => $request->input('name'),
            'type' => filter($request->input('type')),
            'parent_id' => NULL,
            'description' => $request->input('description'),
            'thumb_image' => filter($request->input('thumb_image'))
        ];
        if($request->input('parent_id') && filter($request->input('parent_id')) != ''){
            $data['parent_id'] = trim($request->input('parent_id'));
        }
        $category = CategoryModel::query()->updateOrCreate(['id'=>$id],$data);
        $message = 'Your '.($id ? 'edit' : 'add').' category '.$category->name;
        $logProperties['attributes'] = $category->toArray();
        $activity_group = 'add';
        if (!empty($id)){
            $activity_group = 'edit';
        }
        activity_log(LOG_CATEGORY, $activity_group, $message, $logProperties, $category);

        $returnData = ['redirect' => route('simple_cms.blog.backend.category.index')];
        switch (filter($request->input('return')))
        {
            case "html-tpl-select":
                $returnData['html_tpl_select'] = self::tpl_select();
                break;
        }
        return responseMessage($message . ' success', $returnData);
    }

    public static function restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        if(!empty($id) OR !is_null($id)) {
            $category = CategoryModel::withTrashed()->where('id', $id)->first();
            activity_log(LOG_CATEGORY, 'restore', 'Your restore category ' . $category->name ,[],$category);
            $category->restore();
        }
        return responseMessage('Restore success');
    }

    public static function soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        if(!empty($id) OR !is_null($id)) {
            $category = CategoryModel::where('id', $id)->first();
            activity_log(LOG_CATEGORY, 'soft_delete', 'Your trashed category ' . $category->name ,[],$category);
            $category->delete();
        }
        return responseMessage('Trashed success');
    }

    public static function force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        if(!empty($id) OR !is_null($id)) {
            $category = CategoryModel::withTrashed()->where('id',$id)->first();
            activity_log(LOG_CATEGORY, 'force_delete', 'Your permanent delete category ' . $category->name ,[],$category);
            $category->forceDelete();
            /*CategoriesPostsModel::where(['category_id'=>$id])->forceDelete();*/
        }
        return responseMessage('Permanent delete success');
    }

    /* FOR SELECT LIST */
    public static function tpl_select($selected='')
    {
        $data = CategoryModel::whereNull('parent_id')->with('subs')->orderBy('name','ASC')->cursor();
        return self::tpl_loop_select($data,$selected,'');
    }
    public static function tpl_loop_select($data,$selected='',$nbsp='')
    {
        $nbsp .= $nbsp;
        $html = '';
        foreach ($data as $dt){
            $html .= '<option value="'.$dt->id.'" '.($dt->id == $selected ? 'selected':'').'>'.$nbsp.$dt->name.'</option>';
            if (count($dt->subs)){
                if ($nbsp==''){
                    $nbsp = '--';
                }
                $html .= self::tpl_loop_select($dt->subs,$selected,$nbsp);
                $nbsp = '';
            }
        }
        return $html;
    }

    /* FOR CHECKBOX IN MENU */
    public static function tpl_checkbox_menu($type_menu='post', $selected='')
    {
        $data = CategoryModel::whereType($type_menu)->whereNull('parent_id')->with('subs')->orderBy('name','ASC')->cursor();
        return '<nav class="category_menu">'.self::tpl_loop_checkbox_menu($data,$selected).'</nav>';
    }
    public static function tpl_loop_checkbox_menu($data,$selected='')
    {
        $default_locale = simple_cms_setting('locale');
        $translator_available_locales = simple_cms_setting('available_locales');
        $html = '<ul>';
        foreach ($data as $dt){
            $label_title_translation = [];
            foreach ($translator_available_locales as $local) {
                $label_title_translation[$local] = ( isset($dt->{'name_translation'}) && !empty($dt->{'name_translation'}) ? trans($dt->{'name_translation'}, [], $local) : $dt->name);
            }
            $html .= '<li class="custom-control custom-checkbox"><input id="category_'.$dt->id.'" type="checkbox" class="filled-in custom-control-input" name="categories[]" value=\''.json_encode(['label'=>$label_title_translation,'title'=>$label_title_translation,'url'=>route('simple_cms.blog.category',['post_slug'=>$dt->slug]),'icon'=>'', 'classcss'=>'','target'=>'_self','type'=>'category','status'=>1]).'\'> <label for="category_'.$dt->id.'" class="hover custom-control-label">'.$label_title_translation[$default_locale].'</label>';
            if (count($dt->subs)){
                $html .= self::tpl_loop_checkbox_menu($dt->subs,$selected);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    /* FOR CHECKBOX IN POST */
    public static function tpl_checkbox_post($type_menu='post', $selected='')
    {
        $data = CategoryModel::whereType($type_menu)->whereNull('parent_id')->with('subs')->orderBy('name','ASC')->cursor();
        return '<nav class="category_post">'.self::tpl_loop_checkbox_post($data,$selected).'</nav>';
    }
    public static function tpl_loop_checkbox_post($data,$selected=[])
    {
        $html = '<ul>';
        foreach ($data as $dt){
            $html .= '<li class="custom-control custom-checkbox"><input id="category_'.$dt->id.'" type="checkbox" class="filled-in custom-control-input" name="categories[]" value="'.$dt->id.'" '.(in_array($dt->id,$selected) ? 'checked':'').'><label for="category_'.$dt->id.'" class="hover custom-control-label">'.$dt->name.'</label>';
            if (count($dt->subs)){
                $html .= self::tpl_loop_checkbox_post($dt->subs,$selected);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function jquery_treevew($type_post='post')
    {
        return self::tpl_jquery_treeview(self::treeView($type_post));
    }
    public static function tpl_jquery_treeview($data)
    {
        $html = '<ul>';
        foreach ($data as $dt){
            $html .= '<li data-value="'.$dt['id'].'">'.$dt['text'];
            if (isset($dt['children']) && count($dt['children'])){
                $html .= self::tpl_jquery_treeview($dt['children']);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function treeView($type_post='post',$params=[])
    {
        $treeview = CategoryModel::_treeview($type_post)->toArray();
        foreach( $treeview as $index => $tree ){
            $treeview[$index]['check'] = false;
            if(in_array($tree['id'],$params)){
                $treeview[$index]['check'] = true;
            }
            if(isset($tree['children']) && count($tree['children'])){
                foreach( $tree['children'] as $index1 => $tree1 ){
                    $treeview[$index]['children'][$index1]['check'] = false;
                    if(in_array($tree1['id'],$params)){
                        $treeview[$index]['children'][$index1]['check'] = true;
                    }
                    if(isset($tree1['children']) && count($tree1['children'])){
                        $treeview[$index]['children'][$index1]['check'] = false;
                        foreach( $tree1['children'] as $index2 => $tree2 ){
                            $treeview[$index]['children'][$index1]['children'][$index2]['check'] = false;
                            if(in_array($tree2['id'],$params)){
                                $treeview[$index]['children'][$index1]['children'][$index2]['check'] = true;
                            }
                            if(isset($tree2['children']) && count($tree2['children'])){
                                $treeview[$index]['children'][$index1]['children'][$index2]['check'] = false;
                                foreach( $tree2['children'] as $index3 => $tree3 ){
                                    $treeview[$index]['children'][$index1]['children'][$index2]['children'][$index3]['check'] = false;
                                    if(in_array($tree3['id'],$params)){
                                        $treeview[$index]['children'][$index1]['children'][$index2]['children'][$index3]['check'] = true;
                                    }
                                    if(isset($tree3['children']) && count($tree3['children'])){
                                        $treeview[$index]['children'][$index1]['children'][$index2]['children'][$index3]['check'] = false;
                                        foreach( $tree3['children'] as $index4 => $tree4 ){
                                            $treeview[$index]['children'][$index1]['children'][$index2]['children'][$index3]['children'][$index4]['check'] = false;
                                            if(in_array($tree4['id'],$params)){
                                                $treeview[$index]['children'][$index1]['children'][$index2]['children'][$index3]['children'][$index4]['check'] = true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $treeview;
    }

    public static function generateSlug($id, $slug, $count = 0, $original = '')
    {
        $check_slug = CategoryModel::where('id', '<>', $id)->where('slug', $slug)->count();
        $original = (empty($original) ? $slug : $original);
        if ($check_slug) {
            $count += $check_slug;
            $slug = $original . ($count > 0 ? '-' . $count : '');
            return self::generateSlug($id, $slug, $count, $original);
        }
        return $original . ($count > 0 ? '-' . $count : '');
    }
}
