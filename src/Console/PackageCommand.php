<?php

namespace Acacha\Llum\Console;

/**
 * Class PackageCommand.
 */
class PackageCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'package';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Install laravel package from list of supported/known packages names (see config/packages.php file)';

    /**
     * Command argument.
     *
     * @var string
     */
    protected $argument = 'name';

    /**
     * Command argument description.
     *
     * @var string
     */
    protected $argumentDescription = 'the package name';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'package';
}
