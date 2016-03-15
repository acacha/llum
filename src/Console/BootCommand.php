<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BootCommand.
 */
class BootCommand extends LlumCommand
{
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

}
