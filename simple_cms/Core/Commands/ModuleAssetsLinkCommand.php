<?php

namespace SimpleCMS\Core\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ModuleAssetsLinkCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'simple_cms:module:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the symbolic links module assets to public.';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->laravel['modules']->toCollection() as $collection) {
            $link_path = $this->laravel['modules']->assetPath($collection->getLowerName());
            $target_path = $collection->getExtraPath('Resources/assets');
            if (file_exists($link_path)) {
                $this->error("The [$link_path] link already exists.");
            } else {
                if( !$this->laravel['files']->exists(public_path('simple-cms')) ){
                    $this->laravel['files']->makeDirectory(public_path('simple-cms'), 0775, true, true);
                }
                if( $this->laravel['files']->exists($target_path) ) {
                    $this->laravel->make('files')->link($target_path, $link_path);
                    $this->info("The [$link_path] link has been connected to [$target_path].");
                }else {
                    $this->warn("The [$target_path] not found.");
                }
            }
        }
        $this->info('The links have been created.');
    }

}
