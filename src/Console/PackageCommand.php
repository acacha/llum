<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputOption;

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

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        parent::configure();
        $this->addOption(
            'dev',
            'd',
            InputOption::VALUE_NONE,
            'If set, dev-master branch of package will be installed'
        );
    }
}
