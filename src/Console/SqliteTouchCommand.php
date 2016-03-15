<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\TouchSqliteFile;

/**
 * Class SqliteTouchCommand.
 */
class SqliteTouchCommand extends LlumCommand
{
    use TouchSqliteFile;

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
