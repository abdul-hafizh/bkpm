<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/15/20 3:33 AM ---------
 */

namespace SimpleCMS\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem as File;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ThemePublishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:theme:publish';

    /**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publish/Links theme assets.';

    /**
     * Repository config.
     *
     * @var Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Filesystem
     *
     * @var File
     */
    protected $files;

    /*
     * @param \Illuminate\Config\Repository     $config
     * @param \Illuminate\Filesystem\Filesystem $files
     * */
    public function __construct(Repository $config, File $files)
    {
        $this->config = $config;

        $this->files = $files;

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // The theme is not exists.
        if ( ! $this->files->exists($this->getPath(null)))
        {
            return $this->error('Theme "'.$this->getTheme().'" is not exists.');
        }
        if ( ! $this->files->exists(public_path('themes')) )
        {
            $this->files->makeDirectory(public_path('themes'),0775,true, true);
        }
        /*if ( ! $this->files->exists(public_path('themes/'.$this->getTheme(true))) )
        {
            $this->files->makeDirectory(public_path('themes/'.$this->getTheme(true)),0775,true, true);
        }*/
        /*$this->files->copyDirectory(base_path('Themes/'.$this->getTheme(true).'/assets/'), public_path('themes/'.$this->getTheme(true)));*/
        $linkPath = public_path('themes/'.$this->getTheme(true));
        $targetPath = base_path('Themes/'.$this->getTheme(true).'/assets');
        $this->laravel->make('files')->link($targetPath, $linkPath);
        $this->info('Theme : ' . $this->getTheme() . '; success publish assets.');
    }

    /**
     * Get root writable path.
     *
     * @param  string $path
     * @return string
     */
    protected function getPath($path)
    {
        $rootPath = $this->option('path');

        return $rootPath.'/'.strtolower($this->getTheme()).'/' . $path;
    }

    /**
     * Get the theme name.
     *
     * @param boolean $strtolower
     * @return string
     */
    protected function getTheme($strtolower = false)
    {
        $name = (!empty($this->argument('name')) ? $this->argument('name') : theme()->getThemeName());
        return ($strtolower ? strtolower($name) : $name);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::OPTIONAL, 'Name of the theme.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $path = base_path($this->config->get('theme.themeDir'));

        return array(
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to theme directory.', $path)
        );
    }
}
