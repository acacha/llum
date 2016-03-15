<?php

namespace Acacha\Llum\Console;

/**
 * Class PackageListCommand.
 */
class PackageListCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'package:list';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Shows available packages to list (info taken from config/packages.php)';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'packageList';
}
