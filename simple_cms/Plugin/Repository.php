<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/18/20, 11:58 PM ---------
 */

namespace SimpleCMS\Plugin;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use SimpleCMS\Plugin\Contracts\RepositoryInterface;
use SimpleCMS\Plugin\Process\Installer;
use SimpleCMS\Plugin\Process\Updater;

class Repository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var array|null
     */
    protected $plugins;

    /**
     * Class constructor,
     * @param Application $app
     * @param Filesystem  $filesystem
     */
    public function __construct(Application $app, Filesystem $filesystem)
    {
        $this->app = $app;
        $this->filesystem = $filesystem;
    }

    /**
     * Boots the plugins individually.
     */
    public function register()
    {
        $plugins = $this->getEnabledPlugins();

        foreach ($plugins as $plugin)
            $plugin->registerServiceProvider();
    }

    /**
     * Returns an array containing all enabled plugins.
     * @return array
     */
    public function getEnabledPlugins()
    {
        $plugins = $this->getPlugins();
        $enabledPlugins = [];

        foreach ($plugins as $plugin) {
            if ($plugin->isEnabled()) $enabledPlugins[] = $plugin;
        }

        return $enabledPlugins;
    }

    /**
     * Returns all plugins in an array, either by returning the cached
     * $plugins property, or scanning the plugins directory if it
     * hasn't been populated yet.
     * @return array
     */
    public function getPlugins()
    {
        if (!$this->plugins)
            $this->plugins = $this->scanPluginsDirectory();

        return $this->plugins;
    }

    /**
     * Returns a plugin by its name, or false if it doesn't exist.
     * @param  string      $name
     * @return Plugin|bool
     */
    public function getByName($name)
    {
        if (!$this->plugins) $this->getPlugins();
        $name = \Str::lower($name);
        if (isset($this->plugins[$name])) return $this->plugins[$name];
        return false;
    }

    /**
     * Returns a plugin by its name, or false if it doesn't exist.
     * @param  string      $slug
     * @return Plugin|bool
     */
    public function getBySlug($slug)
    {
        if (!$this->plugins) $this->getPlugins();
        if (isset($this->plugins[$slug])) return $this->plugins[$slug];
        return false;
    }

    /**
     * Scans the plugins directory for plugins and returns an array
     * of Plugin objects.
     * @return array
     */
    protected function scanPluginsDirectory()
    {
        $plugins = [];

        $path = base_path('Plugins');
        $files = $this->filesystem->glob($path . '/*/plugin.json');

        foreach ($files as $file) {
            $pluginName = dirname($file);
            $pluginData = $this->getJsonContents($file);

            $plugins[$pluginData->slug] = $this->createPluginObject($pluginData->name);
        }

        return $plugins;
    }

    /**
     * Grabs the contents of the given JSON file
     * and decodes it into an array.
     * @param  string $filePath
     * @return array
     */
    protected function getJsonContents($filePath)
    {
        return json_decode($this->filesystem->get($filePath));
    }

    /**
     * Creates a Plugin object.
     * @param  string $identifier
     * @return Plugin
     */
    protected function createPluginObject($identifier)
    {
        return new Plugin($this->app, $identifier);
    }

    /**
     * Update dependencies for the specified module.
     *
     * @param Plugin $plugin
     */
    public function update(Plugin $plugin)
    {
        with(new Updater($plugin))->update($plugin);
    }

    /**
     * Install the specified module.
     *
     * @param string $name
     * @param string $version
     * @param string $type
     * @param bool   $subtree
     *
     * @return \Symfony\Component\Process\Process
     */
    public function install($name, $version = 'dev-master', $type = 'composer', $subtree = false)
    {
        $installer = new Installer($name, $version, $type, $subtree);

        return $installer->run();
    }
}
