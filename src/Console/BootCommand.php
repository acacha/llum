<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\DevTools;
use Acacha\Llum\Traits\Migrate;
use Acacha\Llum\Traits\Serve;
use Acacha\Llum\Traits\SqliteEnv;
use Acacha\Llum\Traits\TouchSqliteFile;

/**
 * Class BootCommand.
 */
class BootCommand extends LlumCommand
{
    use DevTools, TouchSqliteFile, SqliteEnv, Migrate, Serve;

    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'boot';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Execute all common first tasks in laravel project';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'boot';

    /**
     * Executes boot command.
     */
    protected function boot()
    {
        if ($this->devtools() == -1) {
            return;
        }
        $this->touchSqliteFile();
        $this->sqliteEnv();
        $this->migrate();
        $this->serve();
    }
}
