<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 1:27 AM ---------
 */

namespace SimpleCMS\Plugin\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use SimpleCMS\Plugin\Generators\PluginGenerator;

class MakePluginCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:plugin:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new plugin.';

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $generator = new PluginGenerator($this->argument('name'), $this->laravel['files'], $this);
        $generator->generate();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
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
