<?php

namespace SimpleCMS\Shortcode\Commands;

use Illuminate\Console\Command;

class MakeShortcodeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'simple_cms:shortcode:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new shortcode class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Shortcode';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/shortcode.stub';
    }

    /**
     * Determine if the class already exists.
     *
     * @param string $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return class_exists($rawName);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        dd($rootNamespace);
        return 'SimpleCMS\Shortcode\Repositories';
    }
}
