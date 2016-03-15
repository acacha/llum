<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\DevTools;

/**
 * Class DevToolsCommand.
 */
class DevToolsCommand extends LlumCommand
{
    use DevTools;

    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'devtools';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Install development/debug tools: laravel-ide-helper and Laravel Debugbar';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'devtools';
}
