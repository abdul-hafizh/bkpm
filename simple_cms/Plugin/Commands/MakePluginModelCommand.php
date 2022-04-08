<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 1:27 AM ---------
 */

namespace SimpleCMS\Plugin\Commands;

use Illuminate\Console\Command;
use SimpleCMS\Plugin\Generators\PluginModelGenerator;
use SimpleCMS\Plugin\Repository;
use Symfony\Component\Console\Input\InputArgument;

class MakePluginModelCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:plugin:make-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a model for the specified plugin.';

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

        $modelName = $this->argument('modelName');

        $generator = new PluginModelGenerator($modelName, $this->laravel, $plugin);
        $generator->generate();

        $this->info("The model [$modelName] has been created for plugin [$pluginName].");

    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['modelName', InputArgument::REQUIRED, 'The name of your model.'],
            ['name', InputArgument::REQUIRED, 'The name of your plugin.'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
