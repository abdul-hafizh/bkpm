<?php

namespace SimpleCMS\Core\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ModulePublishCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'simple_cms:module:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the publish assets of symbolic links module assets to public.';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('simple_cms:module:link');
    }

}
