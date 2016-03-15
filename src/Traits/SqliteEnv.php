<?php

namespace Acacha\Llum\Traits;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SqliteEnv.
 * @property OutputInterface $output
 */
trait SqliteEnv
{
    /**
     * Config .env file.
     */
    protected function sqliteEnv()
    {
        passthru('sed -i \'s/^DB_/#DB_/g\' .env ', $error);
        if ($error !== 0) {
            $this->output->writeln('<error>Error commenting DB_ entries in .env file </error>');
        }
        passthru('sed -i \'s/.*DB_HOST.*/DB_CONNECTION=sqlite\n&/\' .env', $error);
        if ($error !== 0) {
            $this->output->writeln('<error>Error adding DB_CONNECTION=sqlite to .env file </error>');
        } else {
            $this->output->writeln('.env file updated successfully');
        }
    }
}
