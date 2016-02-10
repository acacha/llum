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
                ->setDescription('Touch sqlite file and enable sqlite on .env');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->touchSqliteFile($output);
        $this->configEnv($output);
    }

    /**
     * Touch sqlite database file.
     *
     * @param OutputInterface $output
     * @param $error
     */
    protected function touchSqliteFile(OutputInterface $output, $file = 'database/database.sqlite')
    {
        passthru('touch '.$file, $error);
        if ($error) {
            $output->writeln('<error>Error creating file'.$file.'</error>');
        } else {
            $output->writeln('File '.$file.' created successfully');
        }
    }

    /**
     * Config .env file.
     *
     * @param OutputInterface $output
     * @param $error
     */
    protected function configEnv(OutputInterface $output)
    {
        passthru('sed -i \'s/^DB_/#DB_/g\' .env ', $error);
        if ($error) {
            $output->writeln('<error>Error commenting DB_ entries in .env file </error>');
        }
        passthru('sed -i \'s/.*DB_HOST.*/DB_CONNECTION=sqlite\n&/\' .env', $error);
        if ($error) {
            $output->writeln('<error>Error adding DB_CONNECTION=sqlite to .env file </error>');
        } else {
            $output->writeln('.env file updated successfully');
        }
    }
}
