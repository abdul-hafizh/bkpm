<?php

namespace SimpleCMS\Plugin\Process;

use SimpleCMS\Plugin\Plugin;

class Updater extends Runner
{
    /**
     * Update the dependencies for the specified plugin by given the plugin name.
     *
     * @param Plugin $plugin
     */
    public function update(Plugin $plugin)
    {
//        $plugin = $this->plugin->getByName($plugin);

        chdir(base_path());

        $this->installRequires($plugin);
        $this->installDevRequires($plugin);
        $this->copyScriptsToMainComposerJson($plugin);
    }

    /**
     * @param Plugin $plugin
     */
    private function installRequires(Plugin $plugin)
    {
        $packages = $plugin->getComposerAttr('require', []);

        $concatenatedPackages = '';
        foreach ($packages as $name => $version) {
            $concatenatedPackages .= "\"{$name}:{$version}\" ";
        }

        if (!empty($concatenatedPackages)) {
            $this->run("composer require {$concatenatedPackages}");
        }
    }

    /**
     * @param Plugin $plugin
     */
    private function installDevRequires(Plugin $plugin)
    {
        $devPackages = $plugin->getComposerAttr('require-dev', []);

        $concatenatedPackages = '';
        foreach ($devPackages as $name => $version) {
            $concatenatedPackages .= "\"{$name}:{$version}\" ";
        }

        if (!empty($concatenatedPackages)) {
            $this->run("composer require --dev {$concatenatedPackages}");
        }
    }

    /**
     * @param Plugin $plugin
     */
    private function copyScriptsToMainComposerJson(Plugin $plugin)
    {
        $scripts = $plugin->getComposerAttr('scripts', []);

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        foreach ($scripts as $key => $script) {
            if (array_key_exists($key, $composer['scripts'])) {
                $composer['scripts'][$key] = array_unique(array_merge($composer['scripts'][$key], $script));
                continue;
            }
            $composer['scripts'] = array_merge($composer['scripts'], [$key => $script]);
        }

        file_put_contents(base_path('composer.json'), json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}
