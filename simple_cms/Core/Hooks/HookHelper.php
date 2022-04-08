<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/1/20, 8:27 PM ---------
 */

if (!function_exists('do_action')) {
    /**
     * @param string $hook
     * @param array $args
     * @return mixed
     * @author Ahmad Windi Wijayanto
     */
    function do_action($hook, $args = [])
    {
        return \Hook::action($hook, $args);
    }
}
if (!function_exists('add_action')) {
    /**
     * @param $hook
     * @param $callback
     * @param int $priority
     * @param int $arguments
     * @author Ahmad Windi Wijayanto
     */
    function add_action($hook, $callback, $priority = 20, $arguments = 1)
    {
        \Hook::addAction($hook, $callback, $priority, $arguments);
    }
}
if (!function_exists('remove_action')) {
    /**
     * @param $hook
     * @param $callback
     * @param int $priority
     * @author Ahmad Windi Wijayanto
     */
    function remove_action($hook, $callback, $priority = 20)
    {
        \Hook::removeAction($hook, $callback, $priority);
    }
}
if (!function_exists('remove_all_action')) {
    /**
     * @param $hook
     * @author Ahmad Windi Wijayanto
     */
    function remove_all_action($hook=null)
    {
        \Hook::removeAllActions($hook);
    }
}

if (!function_exists('apply_filter')) {
    /**
     * @param string $hook
     * @param array $args
     * @return mixed
     * @author Ahmad Windi Wijayanto
     */
    function apply_filter($hook, $args=[])
    {
        return \Hook::filter($hook, $args);
    }
}
if (!function_exists('add_filter')) {
    /**
     * @param $hook
     * @param $callback
     * @param int $priority
     * @param int $arguments
     * @author Ahmad Windi Wijayanto
     */
    function add_filter($hook, $callback, $priority = 20, $arguments = 1)
    {
        \Hook::addFilter($hook, $callback, $priority, $arguments);
    }
}
if (!function_exists('remove_filter')) {
    /**
     * @param $hook
     * @param $callback
     * @param int $priority
     * @author Ahmad Windi Wijayanto
     */
    function remove_filter($hook, $callback, $priority = 20)
    {
        \Hook::removeFilter($hook, $callback, $priority);
    }
}
if (!function_exists('remove_all_filter')) {
    /**
     * @param $hook
     * @author Ahmad Windi Wijayanto
     */
    function remove_all_filter($hook=null)
    {
        \Hook::removeAllFilters($hook);
    }
}

if (!function_exists('get_hooks')) {
    /**
     * @param null $name
     * @param bool $isFilter
     * @return array
     * @author Ahmad Windi Wijayanto
     */
    function get_hooks($name = null, $isFilter = true)
    {
        if ($isFilter == true) {
            $listeners = \Hook::getFilter()->getListeners();
        } else {
            $listeners = \Hook::getAction()->getListeners();
        }
        if (empty($name)) {
            return $listeners;
        }
        return array_get($listeners, $name, []);
    }
}
