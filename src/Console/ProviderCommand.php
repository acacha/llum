<?php

namespace Acacha\Llum\Console;

/**
 * Class ProviderCommand.
 */
class ProviderCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'provider';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Adds a provider to Laravel config/app.php file';

    /**
     * Command argument.
     *
     * @var string
     */
    protected $argument = 'provider';

    /**
     * Command argument description.
     *
     * @var string
     */
    protected $argumentDescription = 'the provider to install';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'provider';
}
