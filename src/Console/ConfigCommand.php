<?php

namespace Acacha\Llum\Console;

/**
 * Class ConfigCommand.
 */
class ConfigCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'config';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Install a config/app.php stub file ready to be used with acacha llum';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'installConfigFile';
}
