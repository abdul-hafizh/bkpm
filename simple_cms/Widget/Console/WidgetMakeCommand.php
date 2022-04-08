<?php

namespace SimpleCMS\Widget\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Str;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;
use RuntimeException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class WidgetMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:widget:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new widget';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Widget';

    /**
     * @var File
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @author @author Ahmad Windi Wijayanto
     */
    public function __construct(File $files)
    {

        $this->files = $files;

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

        if ($this->files->isDirectory($this->getPath())) {
            $this->error('Widget "' . $this->getNameClass() . '" is already exists.');
            return false;
        }

        // Directories.
        $this->publishStubs();

        $this->searchAndReplaceInFiles();

        $this->renameFiles($this->getPath());

        $this->info('Widget "' . $this->getNameClass() . '" has been created.');
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
     * Get the destination view path.
     *
     * @return string
     * @author Ahmad Windi Wijayanto
     */
    protected function getPath()
    {
//        return base_path(config('theme.themeDir')) . DIRECTORY_SEPARATOR . setting('theme') . '/widgets/' . $this->getWidget();
        return base_path('Widgets') . DIRECTORY_SEPARATOR . $this->getNameClass();
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
        return 'Widgets\\'.$this->getNameClass();
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
     * @author Ahmad Windi Wijayanto
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the widget to generate.'],
        ];
    }
}
