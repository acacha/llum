<?php

namespace Acacha\Llum\Traits;

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
