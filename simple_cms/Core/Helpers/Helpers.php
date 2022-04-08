<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 19/11/16
 * Time: 23:53
 */

if( ! function_exists('filter'))
{
    function filter($params,$htmlentities=true, $strip_tag=false)
    {
        if(is_array($params)){
            /*return $params;*/
            foreach ($params as $key => $param) {
                $params[$key] = filter($param, $htmlentities, $strip_tag);
            }
            return $params;
        }
        if ($params!=''){
            if ($strip_tag){
                $params = clean_html(trim($params));
            }
            if ($htmlentities){
                return htmlentities(trim($params),ENT_QUOTES,'UTF-8');
            }
            return trim($params);
        }
        return '';
    }
}

if ( ! function_exists('clean_html')){
    function clean_html($text = null){
        if ($text){
            $text = strip_tags($text, '<h1><h2><h3><h4><h5><h6><p><br><ul><li><hr><a><abbr><address><b><blockquote><center><cite><code><del><i><ins><strong><sub><sup><time><u><img><iframe><link><nav><ol><table><caption><th><tr><td><thead><tbody><tfoot><col><colgroup><div><span>');

            $text = str_replace('javascript:', '', $text);
        }
        return $text;
    }
}

if( ! function_exists('htmlEntityDecode'))
{
    function htmlEntityDecode($string) : string
    {
        return html_entity_decode($string);
    }
}

if ( ! function_exists('responseSuccess'))
{
    function responseSuccess($params='',$type=true)
    {
        $params = (empty($params) ? ['message'=>'Success']:$params);
        if($type){
            return response()->json(['status'=>'ok','code'=>200,'body'=>$params],200);
        }
        return $params;
    }
}
if ( ! function_exists('responseError'))
{
    function responseError($params='',$type=true)
    {
        $params = (empty($params) ? ['message'=>'Error']:$params);
        if($type){
            return response()->json(['status'=>'error','code' => 422,'body'=>$params],422);
        }
        return $params;
    }
}
if( ! function_exists('get_pathinfo'))
{
    function get_pathinfo ($source_url_link)
    {
        if (!empty($source_url_link)) {
            return ['dirname' => $dirname, 'basename' => $basename, 'extension' => $extension, 'filename' => $filename] = pathinfo($source_url_link);
        }
        return false;
    }
}

if( ! function_exists('get_extension'))
{
    function get_extension ($source_url_link)
    {
        $extension = get_pathinfo($source_url_link);
        if ($extension) {
            return $extension['extension'];
        }
        return '';
    }
}
if( ! function_exists('get_filename'))
{
    function get_filename ($source_url_link)
    {
        $filename = get_pathinfo($source_url_link);
        if ($filename) {
            return $filename['filename'];
        }
        return '';
    }
}

if( ! function_exists('remove_extension'))
{
    function remove_extension ($params)
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $params);
    }
}

if( ! function_exists('dataTableDom') )
{
    function dataTableDom($dom = 'Bflrtip')
    {
        $domMode = '<"row"';
        if ( stripos($dom, 'B') !== false ){
            $domMode .= '<"col-md-6 toolbar-button-datatable"B>';
        }else{
            $domMode .= '<"col-md-6 toolbar-button-datatable">';
        }
        if ( stripos($dom, 'fl') !== false ){
            $domMode .= '<"col-md-6 text-right"fl>';
        }else{
            $domMode .= '<"col-md-6">';
        }
        $domMode .= '>rt<"row"';
        if ( stripos($dom, 'i') !== false ){
            $domMode .= '<"col-md-3"i>';
        }else{
            $domMode .= '<"col-md-3">';
        }
        if ( stripos($dom, 'p') !== false ){
            $domMode .= '<"col-md-9"p>';
        }else{
            $domMode .= '<"col-md-9">';
        }
        $domMode .= '>';
        return $domMode;
    }
}

if( ! function_exists('file_size')) {
    function file_size($size)
    {
        $file_size_name = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $file_size_name[$i] : '0 Bytes';
    }
}

if ( ! function_exists('mask_email') )
{
    /*
     * @param string $email
     * @param boolean @unmask
     * @return string
     *
     * */
    function mask_email($email, $unmask = false)
    {
        if ($unmask) return $email;
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $prefix = substr($email, 0, strrpos($email, '@'));
            $suffix = substr($email, strripos($email, '@'));
            $len = floor(strlen($prefix) / 2);
            return substr($prefix, 0, $len) . str_repeat('*', $len) . $suffix;
        }
        return '';
    }
}

if ( ! function_exists('mask_number') )
{
    /*
     * @param string $number
     * @param boolean @unmask
     * @return string
     *
     * */
    function mask_number($number, $unmask = false)
    {
        if ($unmask) return $number;
        if (!empty($number)) {
            return str_repeat("*", strlen($number)-4) . substr($number, -4);
        }
        return '';
    }
}

if( ! function_exists('create_path_default') )
{
    function create_path_default($name, $path)
    {
        if($name == ''){
            throw new \ErrorException('Param for created path upload not defined.!');
        }
        if (empty($path)){
            $path = public_path('uploads');
        }
        $name = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '', ''), trim($name)));
        $path_upload = $name.'-'.substr(sha1(time()), 0, 10);
        $full_path = $path . '/'.$path_upload;

        createDirIfNotExists($path);

        \File::makeDirectory($full_path, 0755, true, true);
        \File::makeDirectory($full_path.'/files', 0755, true, true);
        \File::makeDirectory($full_path.'/images', 0755, true, true);
        return str_replace(public_path('/'),'',$full_path);
    }
}

if( ! function_exists('upload_file') )
{
    function upload_file($request,$path_upload,$name_input='files',$name_file='')
    {
        try{
            return \SimpleCMS\Core\Services\CoreService::upload_file($request,$path_upload,$name_input,$name_file);
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }
}
if(! function_exists('createDirIfNotExists'))
{
    function createDirIfNotExists($dirs)
    {
        try {
            if (!is_dir($dirs)) {
                mkdir($dirs, 0755, true);
            } else {
                $files = array_diff(scandir($dirs), array('.', '..'));
                foreach ($files as $file) {
                    if (!file_exists("$dirs/$file")) {
                        mkdir("$dirs/$file", 0755, true);
                    }
                }
            }
            return true;
        } catch (\Exception $e) {
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }
}

if(! function_exists('deleteTreeFolder'))
{
    function deleteTreeFolder($dir) {
        $dir = str_replace(public_path('/'),'',$dir);
        $dir = public_path($dir);
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? deleteTreeFolder("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}

if( ! function_exists('periode') )
{
    function periode()
    {
        return \Carbon\Carbon::now()->year;
    }
}

if( ! function_exists('checkdate_in_range'))
{
    function checkdate_in_range($start_date, $end_date, $date_from_user)
    {
        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }
}

if( ! function_exists('encrypt_decrypt')) {
    function encrypt_decrypt($string, $decrypt=false)
    {
        // you may change these values to your own
        $secret_key = 'qJB0rGtIn5UB1xG03efyCp';
        $secret_iv = 'qJB0rGtIn5UB1xG03efyCp123658NGeselIN';

        $output = '';
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($decrypt){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
            return $output ?: '';
        }
        return base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }
}

if( ! function_exists('ActiveRoute'))
{
    function ActiveRoute($routes, $output = "active")
    {
        if (is_array($routes)) {
            $currentRoute = Route::currentRouteName();
            if (in_array($currentRoute, $routes)) return $output;
        }
        if (Route::currentRouteName() == $routes) return $output;
    }
}

if( ! function_exists('carbonParseTransFormat'))
{
    /*
     * @params date $date
     * @params string d|M|Y|H|i $format
     * */
    function carbonParseTransFormat($date, $format = 'd, M Y H:i')
    {
        \Carbon\Carbon::setLocale(simple_cms_setting('locale_date', 'id'));
        return \Carbon\Carbon::parse($date)
            ->translatedFormat($format);
    }
}
if( ! function_exists('formatDate')) {
    function formatDate($date, $day = false, $time = false, $month =false, $year = false)
    {
        if ($day && $time) {
            return carbonParseTransFormat($date, 'l, d F Y H:i') . ' WIB';
        }
        elseif ($day && !$time){
            return carbonParseTransFormat($date, 'l, d F Y');
        }
        elseif (!$day && $time) {
            return carbonParseTransFormat($date, 'H:i') . ' WIB';
        }
        elseif ($month && $year) {
            return carbonParseTransFormat($date, 'F Y');
        }
        else {
            $format = 'l, d F Y';
            ($time ? $format .= ' H:i' : '');
            $tgl_indo = carbonParseTransFormat($date, $format);
            return $tgl_indo . ($time ? ' WIB' : '');
        }
    }
}

if ( ! function_exists('dateRunTime'))
{
    function dateRunTime($start_date, $end_date)
    {
        $start_date = strtotime($start_date);
        $end_date   = strtotime($end_date);
        $runTime    = $end_date - $start_date;
        return floor($runTime / (60 * 60 * 24)). ' Days';
    }
}

if ( ! function_exists('list_years'))
{
    function list_years()
    {
        $current_year = date('Y');
        $range = range(2020, $current_year);
        $years = array_combine($range, $range);
        arsort($years);
        return $years;
    }
}
if( ! function_exists('serializeCustom'))
{
    function serializeCustom( array $array)
    {
        return json_encode($array);
    }
}
if( ! function_exists('unserializeCustom'))
{
    function unserializeCustom($string)
    {
        return json_decode($string,true);
    }
}

if ( ! function_exists('isJson') )
{
    function isJson($str)
    {
        if (is_string($str)) {
            $json = json_decode($str);
            return $json !== false && !is_null($json) && $str != $json;
        }
        return false;
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param $path
     * @param array $ignore_files
     * @return array
     * @author Ahmad Windi Wijayanto
     */
    function scan_folder($path, $ignore_files = [])
    {
        try {
            if (is_dir($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..'], $ignore_files));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $ex) {
            return [];
        }
    }
}


if (!function_exists('setEnvironment')) {
    /**
     * @param string $key
     * @param string $value
     * @return boolean
     * @author Ahmad Windi Wijayanto
     */
    function setEnvironment($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
        return true;
    }
}

if ( ! function_exists('generate_link_download') )
{
    function generate_link_download($source_url_link, $auth=false)
    {
        return route('simple_cms.blog.download', ['auth' => encrypt_decrypt((boolean)$auth), 'source' => encrypt_decrypt($source_url_link)]);
    }
}

if ( ! function_exists('download') )
{
    function download($source_url_link, $title='', $auth=false)
    {
        $pathinfo = pathinfo($source_url_link);
        if ($pathinfo)
        {
            $extension = 'other';
            if (isset($pathinfo['extension'])) {
                $extension = \Str::lower($pathinfo['extension']);
            }
            if (empty($title)) {
                $title = $pathinfo['basename'];
            }
            return '<div class="col"><a href="'. generate_link_download($source_url_link, $auth) .'" target="_blank" title="Download: '. $title .'"><img class="img-circle img-sm mr-2" src="'. module_asset('core', 'images/file-type/'.$extension.'.png') .'" alt="'. $title .'">'. $title .'</a></div>';
        }
        return '';
    }
}

if ( ! function_exists('view_asset') )
{
    function view_asset($source_url_link, $thumb=true)
    {
        if ($source_url_link)
        {
            if (is_base64($source_url_link)) {
                return $source_url_link;
            }
            if (!$thumb){
                return asset($source_url_link);
            }
            $source_url = asset($source_url_link);
            $pathinfo = pathinfo($source_url);
            $extension = \Str::lower($pathinfo['extension']);
            switch ($extension){
                case 'jpg':
                case 'jpeg':
                case 'png':
                    return asset($source_url_link);
                    break;
                case 'pdf':
                    return module_asset('core', 'images/file-type/'.$extension.'.png');
                    break;
                default:
                    return module_asset('core', 'images/file-type/other.png');
                    break;
            }
        }
        return thumb_image();
    }
}

if ( ! function_exists('form_import_single') )
{
    /*
     * @param string $route_name_action
     * @param string $link_download_template
     * @param string $title_filename_download
     * @param boolean $download_template_must_login
     * */
    function form_import_single($route_name_action, $link_download_template = '', $title_filename_download = '', $download_template_must_login=false)
    {
        \Core::asset()->add('bs-custom-file-input-js', module_asset('core', 'plugins/bs-custom-file-input/bs-custom-file-input.min.js'));
        \Core::asset()->add('event-import-js', module_asset('core','js/event-import.js'));
        \Theme::asset()->usePath(false)->add('bs-custom-file-input-js', module_asset('core', 'plugins/bs-custom-file-input/bs-custom-file-input.min.js'));
        \Theme::asset()->usePath(false)->add('event-import-js', module_asset('core','js/event-import.js'));
        $key = \Str::random(6);
        return view('core::partials.templates.form_import_single', compact('route_name_action', 'link_download_template', 'title_filename_download', 'download_template_must_login', 'key'))->render();
    }
}

if ( ! function_exists('is_base64') )
{
    function is_base64($is_base64)
    {
        return preg_match('/^data:image\/(\w+);base64,/', $is_base64);
    }
}
