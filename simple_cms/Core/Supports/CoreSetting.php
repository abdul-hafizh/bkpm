<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/13/20, 7:31 PM ---------
 */

namespace SimpleCMS\Core\Supports;

use Illuminate\Cache\CacheManager;

class CoreSetting
{
    /**
     * @var string
     */
    protected $prefix = 'settings:';

    /**
     * @var string
     */
    protected $key, $default;

    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * @param \Illuminate\Cache\CacheManager $cache
     *
     */
    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $key
     * @param string $default
     * @return string|object|array
     */
    public function getSetting($key, $default = '')
    {
        $this->key = $key;
        $this->default = $default;
        if (is_array($this->default)){
            $this->default = json_encode($this->default);
        }
        return $this->getFromCache();
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function deleteSetting($key)
    {
        $this->key = $key;
        return $this->delete();
    }

    /**
     * @param string $key
     * @return string
     */
    protected function wildcard($key = '')
    {
        if (!empty($key)) {
            $this->key = $key;
        }
        return $this->prefix . $this->key;
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    protected function has($key='')
    {
        return $this->cache->has($this->wildcard($key));
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    public function forget($key='')
    {
       return $this->cache->forget($this->wildcard($key));
    }

    /**
     *
     * @return mixed
     */
    protected function getFromCache()
    {
        if ( ! app()->runningInConsole() ) {
            if (!$this->has()){
                $this->save();
            }
            $data = json_decode($this->cache->get($this->wildcard()), true);
            if ( count($data) && isset($data['option']) ) {
                if (isJson($data['option'])) {
                    return json_decode($data['option'], true);
                }
                return $data['option'];
            }
        }
        return '';
    }


    protected function save()
    {
        $cache_key = $this->wildcard();
        $this->cache->rememberForever($cache_key, function () {
            $data = \SimpleCMS\Core\Models\SettingModel::select([
                'id',
                'key',
                'option'
            ])->where('key', $this->key )->first();
            if ($data) {
                $data = $data->toArray();
            } else {
                $data = \SimpleCMS\Core\Models\SettingModel::updateOrCreate(['key'=>$this->key],['key'=>$this->key, 'option'=>$this->default]);
                $data = [
                    'id' => $data->id,
                    'key' => $data->key,
                    'option' => $data->option
                ];
            }
            return json_encode($data);
        });
        return true;
    }

    public function update($key, $value)
    {
        if (is_array($value)){
            $value = json_encode($value);
        }
        \SimpleCMS\Core\Models\SettingModel::query()->updateOrCreate(['key'=>$key],['key' => $key, 'option'=>$value]);
        clearCacheSetting($key);
        return true;
    }

    protected function delete()
    {
        \SimpleCMS\Core\Models\SettingModel::where(['key' => $this->key])->forceDelete();
        $this->forget($this->key);
        return true;
    }
}
