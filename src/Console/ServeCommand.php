<?php

namespace Acacha\Llum\Console;

/**
 * Class ServeCommand.
 */
class ServeCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'serve';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'artisan serve with some improvements';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'serve';
}
