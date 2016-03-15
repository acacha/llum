<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\TouchSqliteFile;

/**
 * Class SqliteCommand.
 */
class SqliteCommand extends LlumCommand
{
    use TouchSqliteFile;

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

    /**
     * sqlite command.
     */
    public function sqlite()
    {
        $this->touchSqliteFile();
        $this->configEnv();
    }
}
