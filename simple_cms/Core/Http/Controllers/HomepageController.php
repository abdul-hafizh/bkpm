<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 2:59 PM ---------
 */

namespace SimpleCMS\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        try {
            seo_helper()->setTitle("HOME", site_name())->setDescription(site_description());
            $get_setting_homepage = simple_cms_setting('homepage', 'page_login');
            $get_options_homepage = options_homepage();
            $get_option_homepage  = \Arr::where($get_options_homepage, function ($value, $key) use($get_setting_homepage, $get_options_homepage) {
                return $value['id'] == $get_setting_homepage;
            });

            $get_option_homepage = \Arr::first($get_option_homepage);

            if (is_null($get_option_homepage)){
                $get_option_homepage = $get_options_homepage[0];
            }
            switch ($get_option_homepage['type'])
            {
                case 'redirect':
                    if (auth()->check()){
                        return redirect()->to(link_dashboard());
                    }
                    return redirect($get_option_homepage['value']);
                    break;
                case 'all_post':
                    if (app('modules')->has('Blog')) {
                        return app('post')->load();
                    }
                    break;
                case 'page':

                    if (app('modules')->has('Blog')) {
                        $request->route()->setAction(['as' => 'simple_cms.blog.post']);
                        $post_slug = $get_option_homepage['value'];
                        if (is_numeric($post_slug)){
                            $get_slug = post_query()->select('id', 'slug')->where('id', $post_slug)->first();
                            $post_slug = $get_slug->slug;
                        }
                        $request->route()->setParameter('post_slug', $post_slug);
                        return app('post')->load();
                    }
                    break;
                default:
                    return \Theme::view('index');
                    break;

            }
        }catch (\Exception $e){
            Log::error($e);
            return abort(404);
        }
    }

    public function download(Request $request, $auth, $source)
    {
        $auth = encrypt_decrypt($auth, 2);
        if ($auth && !auth()->check()){
            return abort( 402);
        }
        $source = encrypt_decrypt($source, 2);
        $parse_url = parse_url($source);
        $requestHost = parse_url($request->url(),  PHP_URL_HOST);

        if (in_array($parse_url['host'], [$requestHost]))
        {
            $url = str_replace(['http://'.$requestHost.'/', 'https://'.$requestHost.'/', '//'.$requestHost.'/'], '', $source);
            return response()->download($url);
        }
        return redirect()->to($source);
    }

}
