<?php namespace SimpleCMS\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem as File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThemeDuplicateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'simple_cms:theme:duplicate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Duplicate theme structure from other theme.';

	/**
	 * Repository config.
	 *
	 * @var Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Filesystem
	 *
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * Create a new command instance.
	 *
	 * @param \Illuminate\Config\Repository     $config
	 * @param \Illuminate\Filesystem\Filesystem $files
	 * @return \SimpleCMS\Theme\Commands\ThemeDuplicateCommand
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
	 * @return mixed|void
	 */
	public function handle()
	{
		$theme = strtolower($this->argument('name'));
		$new_theme = strtolower($this->argument('new-name'));

		$theme_path = $this->getPath($theme);
		$new_theme_path = $this->getPath($new_theme);

		if(!$this->files->exists($theme_path)){
			return $this->error('Theme "'.$theme.'" does not exist.');
		}

		if($this->files->exists($new_theme_path)){
			return $this->error('Theme "'.$new_theme.'" is already exists.');
		}

		$this->files->copyDirectory($theme_path, $new_theme_path);

        // Copy assets theme
        /*if ( $this->files->exists(public_path('themes/'.theme($theme)->info('slug'))) ) {
            $this->files->copyDirectory(public_path('themes/' . theme($theme)->info('slug')), public_path('themes/' . theme($new_theme)->info('slug')));
        }*/

		$this->info('Theme "'.$new_theme.'" has been created.');
        // publish assets theme
        $this->call('simple_cms:theme:publish', [
			'name' => $new_theme
		]);
	}


	/**
	 * Get root writable path.
	 *
	 * @param  string $path
	 * @return string
	 */
	protected function getPath($theme, $file = null)
	{
		$rootPath = $this->option('path');

		return $rootPath.'/'.$theme.'/' . $file;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::REQUIRED, 'Name of the theme to duplicate.'),
			array('new-name', InputArgument::REQUIRED, 'Name of the new theme.'),
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
			array('path', null, InputOption::VALUE_OPTIONAL, 'Path to theme directory.', $path),
		);
	}

}
