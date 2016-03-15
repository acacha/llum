<?php

namespace Acacha\Llum\Console;

/**
 * Class SqliteCommand.
 */
class SqliteCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'sqlite';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Touch sqlite file and enable sqlite on .env';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'sqlite';
}
