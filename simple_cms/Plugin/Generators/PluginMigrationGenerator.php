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

class PluginMigrationGenerator extends Generator
{
    /**
     * @var string
     */
    protected $migrationName;

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
    protected $stub = 'pluginDbMigration.stub';

    /**
     * Class constructor.
     * @param string      $migrationName
     * @param Application $app
     * @param Plugin      $plugin
     */
    public function __construct($migrationName, Application $app, Plugin $plugin)
    {
        $this->migrationName = $migrationName;
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
    public function getMigrationName()
    {
        return date('Y_m_d_His') . '_' . studly_case($this->migrationName) . '.php';
    }

    /**
     * Returns the path to the destination file.
     * @return string
     */
    public function getFilePath()
    {
        $migrationName = $this->getMigrationName();

        return $this->plugin->getPath() . 'Database/Migrations/' . $migrationName;
    }

    /**
     * @param  string $contents
     * @return string
     */
    public function replaceStubContents($contents)
    {
        return str_replace('{className}', studly_case($this->migrationName), $contents);
    }
}
