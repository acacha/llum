<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ServiceCommand.
 */
class ServiceCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'service';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'add service or services from file to config/services.php file';

    /**
     * Command argument.
     *
     * @var string
     */
    protected $argument = 'file';

    /**
     * Command argument description.
     *
     * @var string
     */
    protected $argumentDescription = 'the file with service/services to add';

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
        $outputFile = null;
        if ($file = $input->getOption('output-file')) {
            $outputFile = $file;
        }
        $this->service($input->getArgument($this->argument), $outputFile);
    }

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        parent::configure();
        $this->addOption(
            'output-file',
            'o',
            InputOption::VALUE_REQUIRED,
            'If set, config/services.php will not be changed and only shows result on standard output'
        );
    }
}
