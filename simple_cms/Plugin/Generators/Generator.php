<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 2:09 AM ---------
 */

namespace SimpleCMS\Plugin\Generators;


abstract class Generator
{
    /**
     * Returns the name of the plugin.
     * @return string
     */
    abstract public function getPluginName();

    /**
     * Returns the path to the destination file.
     * @return string
     */
    abstract public function getFilePath();

    /**
     * Generates the file.
     * @return mixed
     */
    public function generate()
    {
        $stub = $this->getStubContents($this->stub);
        $path = $this->getFilePath();

        return app('files')->put($path, $stub);
    }

    /**
     * Returns the stub contents of the given stub.
     * @param  string $stub
     * @return string
     */
    protected function getStubContents($stub)
    {
        $contents = app('files')->get(__DIR__ . '/../Commands/stubs/' . $stub);
        $namespace = 'Plugins\\' . $this->getPluginName() . '\\';

        $contents = str_replace('{name}', $this->getPluginName(), $contents);
        $contents = str_replace('{identifier}', \Str::lower($this->getPluginName()), $contents);
        $contents = str_replace('{namespace}', $namespace, $contents);

        if (method_exists($this, 'replaceStubContents'))
            $contents = $this->replaceStubContents($contents);

        return $contents;
    }
}
