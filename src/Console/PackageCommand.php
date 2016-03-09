<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PackageCommand.
 */
class PackageCommand extends LlumCommand
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('package')
                ->setDescription('Install laravel package from list of supported/known packages names (see config/packages.php file)')
                ->addArgument('name', InputArgument::REQUIRED, 'the package name');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $this->package($output, $name);
    }
}
