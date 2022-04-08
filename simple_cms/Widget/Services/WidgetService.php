<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/17/20, 1:16 AM ---------
 */

namespace SimpleCMS\Widget\Services;


use SimpleCMS\Widget\Models\WidgetModel;

class WidgetService
{
    public static function save($request)
    {
        $theme = themeActive();
        $group = filter($request->input('group'));
        /* Delete all widgets */
        WidgetModel::where(['group' => $group, 'theme' => $theme])->forceDelete();
        if ($request->input('widgets'))
        {
            foreach ($request->input('widgets') as $index => $widget) {
                $position = ($index+1);
                $widget['position'] = $position;
                $data = [
                    'widget_id' => trim($widget['id']),
                    'group'     => $group,
                    'theme'     => $theme,
                    'position'  => $position,
                    'settings'  => json_encode($widget)
                ];
                $save_widget = new WidgetModel();
                $save_widget->widget_id = trim($widget['id']);
                $save_widget->group     = $group;
                $save_widget->theme     = $theme;
                $save_widget->position  = $position;
                $save_widget->settings  = json_encode($widget);
                $save_widget->save();
            }
        }
        return responseMessage('Widget saved');
    }

    public static function delete($request)
    {

    }
}
