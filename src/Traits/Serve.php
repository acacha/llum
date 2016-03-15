<?php

namespace Acacha\Llum\Traits;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Serve.
 * @property OutputInterface $output
 */
trait Serve
{
    /**
     * Serve command.
     *
     * @param int $port
     */
    protected function serve($port = 8000)
    {
        $continue = true;
        do {
            if ($this->check_port($port)) {
                $this->output->writeln('<info>Running php artisan serve --port='.$port.'</info>');
                exec('php artisan serve --port='.$port.' > /dev/null 2>&1 &');
                sleep(1);
                if (file_exists('/usr/bin/sensible-browser')) {
                    $this->output->writeln('<info>Opening http://localhost:'.$port.' with default browser</info>');
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
        if (! $fp) {
            return true;
        } else {
            fclose($fp);

            return false;
        }
    }
}
