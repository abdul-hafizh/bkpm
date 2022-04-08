<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 2:44 AM ---------
 */

namespace SimpleCMS\Plugin\Generators;

use Illuminate\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use SimpleCMS\Plugin\Plugin;

class PluginModelGenerator extends Generator
{
    /**
     * @var string
     */
    protected $modelName;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * @var string
     */
    protected $stub = 'pluginModel.stub';

    /**
     * Class constructor.
     * @param string      $modelName
     * @param Application $app
     * @param Plugin      $plugin
     */
    public function __construct($modelName, Application $app, Plugin $plugin)
    {
        $this->modelName = $modelName;
        $this->app = $app;
        $this->plugin = $plugin;
    }

    /**
     * Returns the name of the plugin.
     * @return string
     */
    public function getPluginName()
    {
        return $this->plugin->getName();
    }

    /**
     * Generates a model filename.
     * @return string
     */
    public function getModelName()
    {
        return studly_case($this->modelName) . '.php';
    }

    /**
     * Returns the path to the destination file.
     * @return string
     */
    public function getFilePath()
    {
        $modelName = $this->getModelName();

        return $this->plugin->getPath() . 'Models/' . $modelName;
    }

    /**
     * @param  string $contents
     * @return string
     */
    public function replaceStubContents($contents)
    {
        return str_replace('{className}', studly_case($this->modelName), $contents);
    }
}
