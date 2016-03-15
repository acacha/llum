<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\SqliteEnv;

/**
 * Class SqliteEnvCommand.
 */
class SqliteEnvCommand extends LlumCommand
{
    use SqliteEnv;

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
    protected $method = 'sqliteEnv';
}
