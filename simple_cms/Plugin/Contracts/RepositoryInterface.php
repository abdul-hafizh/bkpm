<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 7:32 AM ---------
 */

namespace SimpleCMS\Plugin\Contracts;


interface RepositoryInterface
{
    /**
     * Boots the plugins individually.
     */
    public function register();

    /**
     * Returns an array containing all enabled plugins.
     * @return array
     */
    public function getEnabledPlugins();

    /**
     * Returns all plugins in an array, either by returning the cached
     * $plugins property, or scanning the plugins directory if it
     * hasn't been populated yet.
     * @return array
     */
    public function getPlugins();

    /**
     * Returns a plugin by its name, or false if it doesn't exist.
     * @param  string      $name
     * @return \SimpleCMS\Plugin\Plugin|bool
     */
    public function getByName($name);

    /**
     * Returns a plugin by its name, or false if it doesn't exist.
     * @param  string      $slug
     * @return \SimpleCMS\Plugin\Plugin|bool
     */
    public function getBySlug($slug);

    /***************************************************************************/

    /**
     * Returns the plugin name.
     * @return string
     */
    public function getName();

    /**
     * Returns the plugin slug.
     * @return string
     */
    public function getSlug();

    /**
     * Returns the plugin namespace.
     * @return string
     */
    public function getNamespace();

    /**
     * Returns the data for the plugin.
     * @return array
     */
    public function getData();

    /**
     * Determines whether the plugin is enabled.
     * @return boolean
     */
    public function isEnabled();

    /**
     * Returns the path to the plugin directory.
     * @return string
     */
    public function getPath();

    /**
     * Enables the plugin.
     * @return mixed
     */
    public function enable();

    /**
     * Disables the plugin.
     * @return mixed
     */
    public function disable();

    /**
     * Quicker method to access the plugin data.
     * @param  string $key
     * @return mixed
     */
    public function __get($key);


}
