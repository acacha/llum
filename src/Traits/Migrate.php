<?php

namespace Acacha\Llum\Traits;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Migrate.
 * @property OutputInterface $output
 */
trait Migrate
{
    /**
     * Migrate database with php artisan migrate.
     */
    protected function migrate()
    {
        $this->output->writeln('<info>Running php artisan migrate...</info>');
        passthru('php artisan migrate');
    }
}
