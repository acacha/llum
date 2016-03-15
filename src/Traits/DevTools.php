<?php

namespace Acacha\Llum\Traits;

/**
 * Class DevTools.
 */
trait DevTools
{
    /**
     * Execute devtools command.
     * @return int -1 if error occurred
     */
    protected function devtools()
    {
        if ($this->idehelper() == -1) {
            return -1;
        }
        if ($this->debugbar() == -1) {
            return -1;
        }
    }

    /**
     *  Install Laravel ide helper package.
     *  @return int -1 if error occurred
     */
    protected function idehelper()
    {
        return $this->package('barryvdh/laravel-ide-helper');
    }

    /**
     * Install Laravel debugbar package.
     * @return int -1 if error occurred
     */
    protected function debugbar()
    {
        return $this->package('barryvdh/laravel-debugbar');
    }

    /**
     * Installs laravel package form config/packages.php file.
     * @see Acacha\Llum\Console\LlumCommand::package
     * @param $package
     * @return mixed
     */
    abstract protected function package($package);
}
