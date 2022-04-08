<?php namespace SimpleCMS\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Composer;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Filesystem;
use League\Flysystem\MountManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThemeGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'simple_cms:theme:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate theme structure.';

	/**
	 * Repository config.
	 *
	 * @var \Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Filesystem
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $files;

    /**
     * @var Composer
     */
    protected $composer;

	/**
	 * Create a new command instance.
	 *
	 * @param \Illuminate\Config\Repository     $config
	 * @param \Illuminate\Filesystem\Filesystem $files
     * @param \Illuminate\Support\Composer $composer
	 * @return \SimpleCMS\Theme\Commands\ThemeGeneratorCommand
	 */
	public function __construct(Repository $config, File $files, Composer $composer)
	{
		$this->config = $config;

		$this->files = $files;

		$this->composer = $composer;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle()
	{
		if ($this->files->exists($this->getPath(null))){
			return $this->error('Theme "'.$this->getTheme().'" is already exists.');
		}

		$this->makeDirs([
            'assets/css',
            'assets/js',
            'assets/img',
            'layouts',
            'src/Http',
            'src/Http/Controllers',
            'src/Providers',
            'partials/sections',
            'views',
            'widgets',
            'routes',
            'helpers'
        ]);

		$this->makeFiles([
            //'layout.blade.php'	=> 'layouts/',
            'frontend.blade.php'	=> 'layouts/',
            'header.blade.php'	=> 'partials/',
            'footer.blade.php'	=> 'partials/',
            'main.blade.php'	=> 'partials/sections/',
            'index.blade.php'	=> 'views/',
            'style.css'			=> 'assets/css/',
            'script.js'			=> 'assets/js/',
            'theme.json'		=> '',
            'gulpfile.js'		=> '',
            'config.php'		=> '',
            'functions.php'     => 'helpers/',
            'web.stub'          => 'routes/',
            'api.php'          => 'routes/',
            '{Theme}Controller.stub' => 'src/Http/Controllers/',
            'RouteServiceProvider.php' => 'src/Providers/',
            'composer.json'     => ''
        ]);

        $this->searchAndReplaceInFiles();
        $this->renameFiles($this->getPath(null));

		$this->info('Theme "'.$this->getTheme().'" has been created.');
		$this->call('simple_cms:theme:publish', [
			'name' => $this->argument('name')
		]);
	}

    /**
     * Search and replace all occurrences of ‘Module’
     * in all files with the name of the new module.
     * @author Ahmad Windi Wijayanto
     */
    public function searchAndReplaceInFiles()
    {

        $path = $this->getPath(null);

        $manager = new MountManager([
            'directory' => new Filesystem(new LocalAdapter($path)),
        ]);

        foreach ($manager->listContents('directory://', true) as $file) {
            if ($file['type'] === 'file') {
                $content = str_replace(['{theme}', '{Theme}',], [strtolower($this->getTheme()), studly_case($this->getTheme())], $manager->read('directory://' . $file['path']));
                $manager->put('directory://' . $file['path'], $content);
            }
        }
    }

    /**
     * Rename models and repositories.
     * @param $location
     * @return boolean
     * @author Ahmad Windi Wijayanto
     */
    public function renameFiles($location)
    {
        $paths = scan_folder($location);
        if (empty($paths)) {
            return false;
        }
        foreach ($paths as $path) {
            $path = $location . DIRECTORY_SEPARATOR . $path;

            $newPath = $this->transformFilename($path);
            rename($path, $newPath);

            $this->renameFiles($newPath);
        }
        return true;
    }

    /**
     * Rename file in path.
     * @param $path
     * @return string
     * @author Sang Nguyen
     */
    public function transformFilename($path)
    {

        return str_replace(
            ['{theme}', '{Theme}', '.stub'],
            [$this->getTheme(), studly_case($this->getTheme()), '.php',],
            $path
        );
    }

	/**
	 * Make directory.
	 *
	 * @param  array $directory
	 * @return void
	 */
	protected function makeDirs($directory)
	{
		foreach ($directory as $path) {
			if (!$this->files->exists($this->getPath($path))){
				$this->files->makeDirectory($this->getPath($path), 0775, true);
			}
		}
	}

	/**
	 * Make file.
	 *
	 * @param  string $file
	 * @param  string $to
	 * @return void
	 */
	protected function makeFiles($files)
	{
		foreach ($files as $file => $to) {
			$template = $this->getTemplate($file);

			$path = $to.$file;

			if (!$this->files->exists($this->getPath($path))){
				$file_path = $this->getPath($path);

				$facade = $this->option('facade');

				if (!is_null($facade)){
					$template = preg_replace('/Theme(\.|::)/', $facade.'$1', $template);
				}

				$this->files->put($file_path, $template);

				if(substr($file_path, -10) == 'theme.json'){
					$this->files->chmod($file_path, 0666);
				}
            }
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
	 * Get default template.
	 *
	 * @param  string $stub
	 * @return string
	 */
	protected function getTemplate($stub)
	{
		$path = realpath(__DIR__.'/../stubs/'.$stub);

		return $this->files->get($path);
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
			array('path', null, InputOption::VALUE_OPTIONAL, 'Path to theme directory.', $path),
			array('facade', null, InputOption::VALUE_OPTIONAL, 'Facade name.', null),
		);
	}

}
