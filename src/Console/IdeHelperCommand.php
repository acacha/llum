<?php

namespace Acacha\Llum\Console;

/**
 * Class IdeHelperCommand.
 */
class IdeHelperCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'idehelper';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Install Laravel Ide Helper package';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'idehelper';
}
