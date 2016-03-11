<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ProviderCommand.
 */
class ProviderCommand extends LlumCommand
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('provider')
                ->setDescription('Adds a provider to Laravel config/app.php file')
                ->addArgument('provider', InputArgument::REQUIRED, 'the provider to install');
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
        $provider = $input->getArgument('provider');
        $this->provider($output, $provider);
    }
}
