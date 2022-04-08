<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 1:27 AM ---------
 */

namespace SimpleCMS\Plugin\Commands;

use Illuminate\Console\Command;
use SimpleCMS\Plugin\Repository;
use Symfony\Component\Console\Input\InputArgument;

class EnablePluginCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:plugin:enable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enables the specified plugin.';

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
        $name = $this->argument('name');
        $plugin = $this->pluginRepo->getByName($name);

        if (!$plugin)
            return $this->error("The [$name] plugin does not exist.");

        if (!$plugin->isEnabled())
            return $this->error("The [$name] plugin is already enabled.");

        $plugin->enable();

        $this->info("The [$name] plugin has been enabled.");
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the plugin.'],
        ];
    }
}
