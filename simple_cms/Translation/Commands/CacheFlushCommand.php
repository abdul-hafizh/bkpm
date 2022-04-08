<?php namespace SimpleCMS\Translation\Commands;

use Illuminate\Console\Command;
use SimpleCMS\Translation\Cache\CacheRepositoryInterface as CacheRepository;

class CacheFlushCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:translator:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Flush the translation cache.";

    /**
     *  Create the cache flushed command
     *
     *  @param  \SimpleCMS\Translation\Cache\CacheRepositoryInterface        $cacheRepository
     *  @param  boolean   $cacheEnabled
     */
    public function __construct(CacheRepository $cacheRepository, $cacheEnabled)
    {
        parent::__construct();
        $this->cacheRepository = $cacheRepository;
        $this->cacheEnabled    = $cacheEnabled;
    }

    /**
     *  Execute the console command.
     *
     *  @return void
     */
    public function fire()
    {
        if (!$this->cacheEnabled) {
            $this->info('The translation cache is disabled.');
        } else {
            $this->cacheRepository->flushAll();
            $this->info('Translation cache cleared.');
        }
    }

    /**
     * Execute the console command for Laravel 5.5
     * this laravel version call handle intead of fire
     */
     public function handle()
     {
         $this->fire();
     }
}
