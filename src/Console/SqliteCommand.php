<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SqliteCommand extends Command
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('sqlite')
                ->setDescription('Sqlite utilities for Laravel');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sqlite_file = 'database/database.sqlite';
        passthru('touch '.$sqlite_file, $error);
        if ($error) {
            $output->writeln('<error>Error creating file'.$sqlite_file.'</error>');
        } else {
            $output->writeln('File '.$sqlite_file.' created successfully');
        }
    }
}
