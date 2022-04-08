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
use Symfony\Component\Console\Input\InputOption;

class PluginSeedCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:plugin:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the database seeds for the specified plugin.';

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
        $pluginName = $this->argument('name');
        $plugin = $this->pluginRepo->getByName($pluginName);

        if (!$plugin)
            return $this->error("Plugin [$pluginName] does not exist.");

        $params = $this->getParameters($plugin);

        $this->call('db:seed', $params);
    }

    /**
     * Get the console command parameters.
     * @param Plugin $plugin
     * @return array
     */
    protected function getParameters(Plugin $plugin)
    {
        $params = [];

        $namespace = $plugin->getNamespace();
        $dbSeeder = $plugin->getName() . 'DatabaseSeeder';
        $dbSeeder = $namespace . 'Database\Seeders\\' . $dbSeeder;

        $params['--class'] = $this->option('class') ? $this->option('class') : $dbSeeder;
        $params['--database'] = $this->option('database');

        return $params;
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

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the plugin\'s root seeder.'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed.']
        ];
    }
}
