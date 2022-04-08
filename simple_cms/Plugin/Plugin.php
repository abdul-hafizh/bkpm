<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 12:05 AM ---------
 */

namespace SimpleCMS\Plugin;


use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use SimpleCMS\Plugin\Process\Installer;
use SimpleCMS\Plugin\Process\Updater;

class Plugin
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * @var array of cached Json objects, keyed by filename
     */
    protected $pluginJson = [];

    /**
     * Class constructor.
     * @param Application $app
     * @param string      $name
     */
    public function __construct(Application $app, $name)
    {
        $this->app = $app;
        $this->name = $name;
    }

    /**
     * Returns the plugin name.
     * @return string
     */
    public function getName()
    {
        return $this->getData()->name;
    }

    /**
     * Returns the plugin slug.
     * @return string
     */
    public function getSlug()
    {
        return $this->getData()->slug;
    }

    /**
     * Returns the plugin namespace.
     * @return string
     */
    public function getNamespace()
    {
        return 'Plugins\\' . $this->name . '\\';
    }

    /**
     * Returns the data for the plugin.
     * @return array
     */
    public function getData()
    {
        if (!$this->data)
            $this->data = $this->loadData();

        return $this->data;
    }

    /**
     * Determines whether the plugin is enabled.
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->getData()->enabled;
    }

    /**
     * Returns the path to the plugin directory.
     * @return string
     */
    public function getPath()
    {
        return base_path('Plugins/' . $this->name . '/');
    }

    /**
     * Returns the path to the database migrations directory.
     * @return string
     */
    public function getMigrationPath()
    {
        return $this->getPath() . 'Database/Migrations/';
    }

    /**
     * Enables the plugin.
     * @return mixed
     */
    public function enable()
    {
        return $this->setData('enabled', true);
    }

    /**
     * Disables the plugin.
     * @return mixed
     */
    public function disable()
    {
        return $this->setData('enabled', false);
    }

    /**
     * Registers the service provider.
     * @return mixed
     */
    public function registerServiceProvider()
    {
        $provider = 'Plugins\\' . $this->name . '\\Providers\\' . $this->name . 'ServiceProvider';

        return $this->app->register($provider);
    }

    /**
     * Quicker method to access the plugin data.
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getData()->$key;
    }

    /**
     * Returns the JSON decoded plugin data, loaded from the plugin.json file.
     * @return array
     */
    protected function loadData()
    {
        $jsonPath = $this->getPath() . 'plugin.json';
        $contents = $this->app['files']->get($jsonPath);

        return json_decode($contents);
    }

    /**
     * Sets a value in the plugin.json file and saves it if $save is true.
     * @param  string  $key
     * @param  mixed  $value
     * @param  boolean $save
     * @return mixed
     */
    protected function setData($key, $value, $save = true)
    {
        $data = $this->getData();
        $data->$key = $value;

        if (!$save)
            return $this->data = $data;

        $data = json_encode($this->data, \JSON_PRETTY_PRINT);
        $path = $this->getPath() . 'plugin.json';

        return $this->app['files']->put($path, $data);
    }

    /**
     * Get a specific data from composer.json file by given the key.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function getComposerAttr($key, $default = null)
    {
        return $this->json('composer.json')->get($key, $default);
    }

    /**
     * Get json contents from the cache, setting as needed.
     *
     * @param string $file
     *
     * @return Json
     */
    public function json($file = null) : Json
    {
        if ($file === null) {
            $file = 'plugin.json';
        }

        return Arr::get($this->pluginJson, $file, function () use ($file) {
            return $this->pluginJson[$file] = new Json($this->getPath() . '/' . $file, app('files'));
        });
    }
}
