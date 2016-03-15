<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AliasCommand.
 */
class AliasCommand extends LlumCommand
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('alias')
                ->setDescription('Adds a alias/facade to Laravel config/app.php file')
                ->addArgument('aliasName', InputArgument::REQUIRED, 'the alias name')
                ->addArgument('aliasClass', InputArgument::REQUIRED, 'the alias class');
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
        $this->output = $output;
        $aliasName = $input->getArgument('aliasName');
        $aliasClass = $input->getArgument('aliasClass');
        $this->alias($aliasName, $aliasClass);
    }
}
