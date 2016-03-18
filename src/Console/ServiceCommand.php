<?php

namespace Acacha\Llum\Console;

/**
 * Class ServiceCommand.
 */
class ServiceCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'service';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'add service or services from file to config/services.php file';

    /**
     * Command argument.
     *
     * @var string
     */
    protected $argument = 'file';

    /**
     * Command argument description.
     *
     * @var string
     */
    protected $argumentDescription = 'the file with service/services to add';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'service';
}
