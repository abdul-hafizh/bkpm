<?php namespace SimpleCMS\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem as File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThemeDestroyCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'simple_cms:theme:destroy';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Remove a theme.';

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

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Config\Repository     $config
     * @param \Illuminate\Filesystem\Filesystem $files
     * @return \SimpleCMS\Theme\Commands\ThemeDestroyCommand
     */
	public function __construct(Repository $config, File $files)
	{
		$this->config = $config;

		$this->files = $files;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle()
	{
		// The theme is not exists.
		if ( ! $this->files->exists($this->getPath(null)))
		{
			return $this->error('Theme "'.$this->getTheme().'" is not exists.');
		}

		$themePath = $this->getPath(null);

		if ($this->confirm('Are you sure you want to permanently delete?'))
		{
			// Delete permanent.
			$this->files->deleteDirectory($themePath, false);

			// Delete permanent assets theme
			if ( is_link(public_path('themes/'.$this->getTheme())) ) {
                $this->files->delete(public_path('themes/' . $this->getTheme()), false);
            }

			$this->info('Theme "'.$this->getTheme().'" has been destroyed.');
		}
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
	 * @return string
	 */
	protected function getTheme()
	{
		return strtolower($this->argument('name'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'Name of the theme to generate.'),
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