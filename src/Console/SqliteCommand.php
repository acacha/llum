<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SqliteCommand.
 */
class SqliteCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'sqlite';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Touch sqlite file and enable sqlite on .env';

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
        $this->touchSqliteFile($output);
        $this->configEnv($output);
    }
}
