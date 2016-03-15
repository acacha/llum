<?php

namespace Acacha\Llum\Console;

/**
 * Class MigrateCommand.
 */
class MigrateCommand extends LlumCommand
{
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
