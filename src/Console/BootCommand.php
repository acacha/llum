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
     * Configure the command options.
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('boot')
                ->setDescription('Execute all common first tasks in laravel project');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->devtools($output);
        $this->touchSqliteFile($output);
        $this->configEnv($output);
        $this->serve($output);
    }
}
