<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DebugBarCommand.
 */
class DebugBarCommand extends LlumCommand
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('debugbar')
                ->setDescription('Install Laravel Debugbar package');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->debugbar($output);
    }
}
