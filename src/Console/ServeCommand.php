<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\Serve;

/**
 * Class ServeCommand.
 */
class ServeCommand extends LlumCommand
{
    use Serve;

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
