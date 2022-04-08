<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 2:17 AM ---------
 */

namespace SimpleCMS\Plugin\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command as Console;

class PluginGenerator extends Generator
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Console
     */
    protected $console;

    /**
     * @var array
     */
    protected $foldersToGenerate = [
        'Config',
        'Commands',
        'Helpers',
        'Events',
        'Http',
        'Http/Middleware',
        'Http/Controllers',
        'Http/Requests',
        'Providers',
        'Models',
        'Database',
        'Database/Seeders',
        'Database/Migrations',
        'Resources',
        'Resources/assets',
        'Resources/views',
        'Resources/lang',
        'Routes'
    ];

    /**
     * @var array
     */
    protected $filesToCreate = [
        'Config/config.php'							=>	'pluginConfig.stub',
        'Routes/web.php'							=>	'pluginRoutes.stub',
        'Routes/api.php'							=>	'pluginApi.stub',
        'Http/Controllers/{name}Controller.php'		=>	'pluginController.stub',
        'Providers/{name}ServiceProvider.php'		=>	'pluginProvider.stub',
        'Providers/RouteServiceProvider.php'		=>	'pluginRouteProvider.stub',
        'plugin.json'								=>	'pluginJson.stub',
        'Database/Seeders/{name}DatabaseSeeder.php'	=>	'pluginDbSeeder.stub',
        'Resources/views/index.blade.php'           =>  'pluginIndexBlade.stub',
        'composer.json'                             =>  'pluginComposer.stub',
        '.gitignore'                                =>  '.gitignore.stub'
    ];

    /**
     * Class constructor.
     * @param string     $name
     * @param Filesystem $filesystem
     * @param Console    $console
     */
    public function __construct($name, Filesystem $filesystem, Console $console)
    {
        $this->name = \Str::studly($name);
        $this->filesystem = $filesystem;
        $this->console = $console;
    }

    /**
     * Runs the generator.
     */
    public function generate()
    {
        $this->createPluginsDir();
        $this->createFolders();
        $this->createFiles();

        $this->console->info("Your plugin [$this->name] has been generated.");
    }

    /**
     * Returns the name of the plugin.
     * @return string
     */
    public function getPluginName()
    {
        return $this->name;
    }

    /**
     * Returns the path to the destination file.
     * @return string
     */
    public function getFilePath()
    {
        // Not needed for this class.
    }

    /**
     * Creates the Plugins directory if it doesn't already exist.
     */
    protected function createPluginsDir()
    {
        $path = base_path('Plugins');

        if (!$this->filesystem->isDirectory($path))
            $this->filesystem->makeDirectory($path);
    }

    /**
     * Creates the plugin directory and other folders.
     */
    protected function createFolders()
    {
        $path = base_path('Plugins/' . $this->name);

        $this->filesystem->makeDirectory($path);

        foreach ($this->foldersToGenerate as $folder)
            $this->filesystem->makeDirectory($path . '/' . $folder);
    }

    /**
     * Creates the plugin files.
     */
    protected function createFiles()
    {
        foreach ($this->filesToCreate as $file => $stub) {
            $file = str_replace('{name}', $this->name, $file);
            $path = base_path('Plugins/' . $this->name . '/' . $file);
            $stub = $this->getStubContents($stub);

            $this->filesystem->put($path, $stub);
        }
    }
}
