<?php

namespace Acacha\Llum\Traits;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TouchSqliteFile.
 * @property OutputInterface $output
 */
trait TouchSqliteFile
{
    /**
     * Touch sqlite database file.
     *
     * @param string $file
     */
    protected function touchSqliteFile($file = 'database/database.sqlite')
    {
        $this->touchFile($file);
    }

    /**
     * Touch a file.
     * @param string $file
     */
    protected function touchFile($file)
    {
        passthru('touch '.$file, $error);
        if ($error !== 0) {
            $this->output->writeln('<error>Error creating file '.$file.'</error>');
        } else {
            $this->output->writeln('<info>File '.$file.' created successfully</info>');
        }
    }
}
