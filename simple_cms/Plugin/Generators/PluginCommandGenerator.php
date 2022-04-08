<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 2:12 AM ---------
 */

namespace SimpleCMS\Plugin\Generators;


use Illuminate\Foundation\Application;
use SimpleCMS\Plugin\Plugin;

class PluginCommandGenerator extends Generator
{
    /**
     * @var string
     */
    protected $commandName;

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
    protected $stub = 'pluginCommand.stub';

    /**
     * Class constructor.
     * @param string      $commandName
     * @param Application $app
     * @param Plugin      $plugin
     */
    public function __construct($commandName, Application $app, Plugin $plugin)
    {
        $this->commandName = $commandName;
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
        $fileName = studly_case($this->commandName) . '.php';

        return $this->plugin->getPath() . 'Commands/' . $fileName;
    }

    /**
     * @param  string $contents
     * @return string
     */
    public function replaceStubContents($contents)
    {
        return str_replace('{className}', studly_case($this->commandName), $contents);
    }
}
