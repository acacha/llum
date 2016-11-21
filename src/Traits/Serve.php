<?php

namespace Acacha\Llum\Traits;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Serve.
 *
 * @property OutputInterface $output
 */
trait Serve
{
    /**
     * Serve command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function serve(InputInterface $input, OutputInterface $output)
    {
        $port = $this->port($input);
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
        if (!$fp) {
            return true;
        } else {
            fclose($fp);

            return false;
        }
    }

    /**
     * Configure command.
     */
    public function configure()
    {
        parent::configure();

        $this
            // configure an argument
            ->addArgument('port', InputArgument::OPTIONAL, 'Port number')
        ;
    }

    /**
     * Obtain port.
     *
     * @param InputInterface $input
     * @return integer
     */
    protected function port(InputInterface $input) {
        $name = $input->getArgument('port');
        return isset($name) ? (int) $name : 8080;
    }

    /**
     * Method provided from \Symfony\Component\Console\Command\Command.
     *
     * @param string $name        The argument name
     * @param int    $mode        The argument mode: InputArgument::REQUIRED or InputArgument::OPTIONAL
     * @param string $description A description text
     * @param mixed  $default     The default value (for InputArgument::OPTIONAL mode only)
     *
     * @return Command The current instance
     */
    abstract public function addArgument($name, $mode = null, $description = '', $default = null);
}
