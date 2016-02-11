<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LlumCommand.
 */
abstract class LlumCommand extends Command
{
    /**
     * Touch sqlite database file.
     *
     * @param OutputInterface $output
     * @param string          $file
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

    /**
     * Serve command.
     *
     * @param OutputInterface $output
     * @param int             $port
     */
    protected function serve(OutputInterface $output, $port = 8000)
    {
        $continue = true;
        do {
            if (check_port($port)) {
                $output->writeln('<info>Executing php artisan serve --port='.$port.'</info>');
                exec('php artisan serve --port='.$port.' > /dev/null 2>&1 &');
                sleep(1);
                if (file_exists('/usr/bin/sensible-browser')) {
                    $output->writeln('<info>Opening http://localhost:'.$port.' with default browser</info>');
                    passthru('/usr/bin/sensible-browser http://localhost:'.$port);
                }
                $continue = false;
            }
            ++$port;
        } while ($continue);
    }

    /**
     * Check if port is in use.
     *
     * @param int    $port
     * @param string $host
     * @param int    $timeout
     *
     * @return bool
     */
    protected function check_port($port = 8000, $host = '127.0.0.1', $timeout = 3)
    {
        $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$fp) {
            return true;
        } else {
            fclose($fp);

            return false;
        }
    }
}
