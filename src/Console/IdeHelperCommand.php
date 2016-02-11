<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class IdeHelperCommand.
 */
class IdeHelperCommand extends LlumCommand
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('idehelper')
                ->setDescription('Install Laravel Ide Helper package');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->idehelper($output);
    }
}
