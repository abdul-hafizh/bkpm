<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 2:47 AM ---------
 */

namespace SimpleCMS\Plugin\Generators;

use Illuminate\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use SimpleCMS\Plugin\Plugin;

class PluginRequestGenerator extends Generator
{
    /**
     * @var string
     */
    protected $requestName;

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
    protected $stub = 'pluginRequest.stub';

    /**
     * Class constructor.
     * @param string      $requestName
     * @param Application $app
     * @param Plugin      $plugin
     */
    public function __construct($requestName, Application $app, Plugin $plugin)
    {
        $this->requestName = $requestName;
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
     * Generates a migration filename.
     * @return string
     */
    public function getRequestName()
    {
        return studly_case($this->requestName);
    }

    /**
     * Returns the path to the destination file.
     * @return string
     */
    public function getFilePath()
    {
        return $this->plugin->getPath() . 'Http/Requests/' . $this->getRequestName() . '.php';
    }

    /**
     * @param  string $contents
     * @return string
     */
    public function replaceStubContents($contents)
    {
        return str_replace('{className}', studly_case($this->requestName), $contents);
    }
}
