<?php

namespace Acacha\Llum\Console;

/**
 * Class SqliteEnvCommand.
 */
class SqliteEnvCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'sqlite:env';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Config .env to use sqlite';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'configEnv';
}
