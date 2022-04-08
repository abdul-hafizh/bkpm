<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:46 AM ---------
 */

define('LOG_MENU', 'LOG_MENU');
define('MENU_ADMINLTE3', 'adminlte3');
define('MENU_BACKEND_PRESENTER', \SimpleCMS\Menu\Presenters\Admin\Adminlte3Presenter::class);
define('MENU_FRONTEND', 'simple-cms-theme-menu');

if ( ! function_exists('clearCacheMenu'))
{
    function clearCacheMenu($wildcard)
    {
        $cache_key = 'menu:' . $wildcard;
        return \Cache::forget($cache_key);
    }
}

if ( ! function_exists('getCacheMenu'))
{
    function getCacheMenu($wildcard, $presenter='')
    {
        $cache_key = 'menu:' . $wildcard;
        if ( ! \Cache::has($cache_key) ) {
            \Cache::rememberForever($cache_key, function () use ($wildcard, $presenter) {
                $data = \SimpleCMS\Menu\Models\MenuModel::select([
                    'id',
                    'slug',
                    'name',
                    'option',
                    'presenter'
                ])->where('slug', $wildcard)->first();
                if ($data) {
                    $data = [
                        'id'        => $data->id,
                        'slug'      => $data->slug,
                        'name'      => $data->name,
                        'option'    => ( isJson($data->option) ? json_decode($data->option) : [] ),
                        'presenter' => $data->presenter
                    ];
                } else {
                    $data = \SimpleCMS\Menu\Models\MenuModel::updateOrCreate(['slug'=>$wildcard],[
                        'slug'      => $wildcard,
                        'name'      => ucwords(str_replace(['-', '_'], ' ', $wildcard)),
                        'option'    => json_encode([]),
                        'presenter' => $presenter
                    ]);
                    $data = [
                        'id'        => $data->id,
                        'slug'      => $data->slug,
                        'name'      => $data->name,
                        'option'    => ( isJson($data->option) ? json_decode($data->option) : [] ),
                        'presenter' => $data->presenter
                    ];
                }
                return json_encode($data);
            });
            return getCacheMenu($wildcard);
        }
        return collect(json_decode(\Cache::get($cache_key), false))->recursive();
    }
}


if ( ! function_exists('build_menu_presenter'))
{
    function build_menu_presenter($menu_slug)
    {
        $build = \SimpleCMS\Menu\Services\MenuService::build_menu($menu_slug);
        return true;
    }
}