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

class PluginMigrateRollbackCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:plugin:migrate-rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rolls back the migrations for the given plugin.';

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

        $migrationsPath = $plugin->getMigrationPath();
        $files = $this->laravel['files']->glob($migrationsPath . '*');

        foreach ($files as $file) {
            $this->laravel['files']->requireOnce($file);
        }

        $this->call('migrate:rollback', $this->getParameters($plugin));
    }

    /**
     * Get the console command parameters.
     * @param Plugin $plugin
     * @return array
     */
    protected function getParameters(Plugin $plugin)
    {
        $params = [];

        if ($option = $this->option('database')) $params['--database'] = $option;
        if ($option = $this->option('force')) $params['--force'] = $option;
        if ($option = $this->option('pretend')) $params['--pretend'] = $option;

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
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run while in production.'],
            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.']
        ];
    }
}
