<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 2:15 AM ---------
 */

namespace SimpleCMS\Plugin\Generators;


use Illuminate\Foundation\Application;
use SimpleCMS\Plugin\Plugin;

class PluginEventGenerator extends Generator
{
    /**
     * @var string
     */
    protected $eventName;

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
    protected $stub = 'pluginEvent.stub';

    /**
     * Class constructor.
     * @param string      $eventName
     * @param Application $app
     * @param Plugin      $plugin
     */
    public function __construct($eventName, Application $app, Plugin $plugin)
    {
        $this->eventName = $eventName;
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
     * Returns the path to the destination file.
     * @return string
     */
    public function getFilePath()
    {
        $fileName = studly_case($this->eventName) . '.php';

        return $this->plugin->getPath() . 'Events/' . $fileName;
    }

    /**
     * @param  string $contents
     * @return string
     */
    public function replaceStubContents($contents)
    {
        return str_replace('{className}', studly_case($this->eventName), $contents);
    }
}
