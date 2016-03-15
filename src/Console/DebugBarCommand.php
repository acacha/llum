<?php

namespace Acacha\Llum\Console;

/**
 * Class DebugBarCommand.
 */
class DebugBarCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'debugbar';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Install Laravel Debugbar package';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'debugbar';
}
