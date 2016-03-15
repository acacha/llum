<?php

namespace Acacha\Llum\Console;

/**
 * Class SqliteTouchCommand.
 */
class SqliteTouchCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'sqlite:touch';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Touch database/database.sqlite file';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'touchSqliteFile';
}
