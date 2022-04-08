<?php

namespace SimpleCMS\Plugin\Process;

use SimpleCMS\Plugin\Contracts\RunableInterface;
use SimpleCMS\Plugin\Plugin;

class Runner implements RunableInterface
{
    /**
     * The module instance.
     * @var Plugin
     */
    protected $plugin;

    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Run the given command.
     *
     * @param string $command
     */
    public function run($command)
    {
        passthru($command);
    }
}
