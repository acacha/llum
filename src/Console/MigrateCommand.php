<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\Migrate;

/**
 * Class MigrateCommand.
 */
class MigrateCommand extends LlumCommand
{
    use Migrate;

    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'migrate';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'execute migrations with php artisan migrate';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'migrate';
}
