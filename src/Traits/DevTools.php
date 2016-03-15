<?php

namespace Acacha\Llum\Traits;

/**
 * Class DevTools.
 */
trait DevTools
{
    /**
     * Execute devtools command.
     */
    protected function devtools()
    {
        $this->idehelper();
        $this->debugbar();
    }

    /**
     *  Install Laravel ide helper package.
     */
    protected function idehelper()
    {
        $this->package('barryvdh/laravel-ide-helper');
    }

    /**
     * Install Laravel debugbar package.
     */
    protected function debugbar()
    {
        $this->package('barryvdh/laravel-debugbar');
    }
}
