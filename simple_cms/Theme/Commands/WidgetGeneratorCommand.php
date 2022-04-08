<?php namespace SimpleCMS\Theme\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Str;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class WidgetGeneratorCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:theme:widget';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate widget structure.';

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
     * @var string
     */
    protected $theme;
    protected $type = 'Widget';

    /**
     * Create a new command instance.
     * @param \Illuminate\Config\Repository $config
     * @param \Illuminate\Filesystem\Filesystem $files
     * @author @author Ahmad Windi Wijayanto
     */
    public function __construct(Repository $config, File $files)
    {
        $this->config = $config;
        $this->files = $files;
        $this->theme = app('simple_cms_setting')->getSetting('theme_active');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return boolean
     * @author Ahmad Windi Wijayanto
     */
    public function handle()
    {
        if ($this->argument('theme')){
            $this->theme = $this->argument('theme');
        }

        if ($this->files->isDirectory($this->getPath())) {
            $this->error('Widget['.$this->getTheme().'] "' . $this->getNameClass() . '" is already exists.');
            return false;
        }

        // Directories.
        $this->publishStubs();

        $this->searchAndReplaceInFiles();

        $this->renameFiles($this->getPath());

        $this->info('Widget['.$this->getTheme().'] "' . $this->getNameClass() . '" has been created.');
        return true;
    }

    /**
     * Generate the module in Modules directory.
     * @author Ahmad Windi Wijayanto
     */
    private function publishStubs()
    {
        $from = base_path('simple_cms/Widget/Console/stubs');

        if ($this->files->isDirectory($from)) {
            $this->publishDirectory($from, $this->getPath());
        } else {
            $this->error('Can’t locate path: <' . $from . '>');
        }
    }

    /**
     * Publish the directory to the given directory.
     *
     * @param string $from
     * @param string $to
     * @return void
     * @author Ahmad Windi Wijayanto
     */
    protected function publishDirectory($from, $to)
    {
        $manager = new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to' => new Flysystem(new LocalAdapter($to)),
        ]);

        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file' && (!$manager->has('to://' . $file['path']) || $this->option('force'))) {
                $manager->put('to://' . $file['path'], $manager->read('from://' . $file['path']));
            }
        }
    }

    /**
     * Search and replace all occurrences of ‘Module’
     * in all files with the name of the new module.
     * @author Ahmad Windi Wijayanto
     */
    public function searchAndReplaceInFiles()
    {

        $path = $this->getPath();

        $manager = new MountManager([
            'directory' => new Flysystem(new LocalAdapter($path)),
        ]);

        foreach ($manager->listContents('directory://', true) as $file) {
            if ($file['type'] === 'file') {
                $content = str_replace(['{{namespace}}', '{{class}}', '{{view}}'], [$this->getNamespace(), $this->getNameClass(), $this->getNameView()], $manager->read('directory://' . $file['path']));
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
     * @author Ahmad Windi Wijayanto
     */
    public function transformFilename($path)
    {

        return str_replace(
            ['{widget}', '.stub'],
            [$this->getNameClass(), '.php'],
            $path
        );
    }

    /**
     * Get the theme name.
     *
     * @return string
     */
    protected function getTheme()
    {
        return Str::lower($this->theme);
    }

    /**
     * Get the destination view path.
     * @return string
     * @author Ahmad Windi Wijayanto
     */
    protected function getPath()
    {
        $rootPath = base_path($this->config->get('theme.themeDir'));
        return $rootPath.'/'.$this->getTheme().'/widgets/'.$this->getNameClass();
    }

    /**
     * Get the widget name.
     * @param boolean $lower
     * @return string
     * @author Ahmad Windi Wijayanto
     */
    protected function getWidget($lower=false)
    {
        $name = $this->argument('name');
        if ($lower){
            return Str::lower($name);
        }
        return $name;
    }

    /**
     * Get the namespace.
     * @return string
     * @author Ahmad Windi Wijayanto
     */
    protected function getNamespace()
    {
        return 'Themes\\'.$this->getTheme().'\\widgets\\'.$this->getNameClass();
    }

    /**
     * Get the nameClass.
     * @return string
     * @author Ahmad Windi Wijayanto
     */
    protected function getNameClass()
    {
        $nameClass = $this->getWidget();
        if ( ! Str::contains($nameClass, $this->type)) {
            $nameClass = $nameClass . $this->type;
        }
        return $nameClass;
    }

    /**
     * Get the nameView.
     * @return string
     * @author Ahmad Windi Wijayanto
     */
    protected function getNameView()
    {
        return 'simple_cms.widget::'.$this->getNameClass().'.templates.frontend';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the widget to generate.'),
            array('theme', InputArgument::OPTIONAL, 'Theme name to generate widget view file.')
        );
    }

}
