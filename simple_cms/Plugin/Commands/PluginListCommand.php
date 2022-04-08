<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 1:27 AM ---------
 */

namespace SimpleCMS\Plugin\Commands;

use Illuminate\Console\Command;
use SimpleCMS\Plugin\Plugin;
use SimpleCMS\Plugin\Repository;
use Symfony\Component\Console\Input\InputArgument;

class PluginListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:plugin:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all plugin.';

    /**
     * @var Repository
     */
    protected $pluginRepo;

    /**
     * Class constructor.
     * @param Repository $pluginRepo
     */
    public function __construct(Repository $pluginRepo)
    {
        $this->pluginRepo = $pluginRepo;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $plugins = $this->pluginRepo->getPlugins();
        if (!count($plugins)){
            return $this->info('Not have plugin installed.');
        }
        foreach ($plugins as $plugin) {
            $rows[] = $this->moduleToRow($plugin);
        }
        $this->table(['Name', 'Description', 'Status'], $rows);
    }

    /**
     * Converts a plugin object to a table row.
     * @param  Plugin $plugin
     * @return array
     */
    public function moduleToRow(Plugin $plugin)
    {
        return [
            'name'			=>	$plugin->name,
            'description'	=>	$plugin->description,
            'enabled'		=>	$plugin->isEnabled() ? '<info>Enabled</info>' : '<error>Disabled</error>'
        ];
    }
}
