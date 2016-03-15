<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\DevTools;

/**
 * Class BootCommand.
 */
class BootCommand extends LlumCommand
{
    use DevTools;
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
        $this->devtools();
        $this->touchSqliteFile();
        $this->configEnv();
        $this->migrate();
        $this->serve();
    }
}
