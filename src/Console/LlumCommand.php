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

    /**
     * Install /stubs/app.php into /config/app.php.
     */
    protected function installConfigAppFile(OutputInterface $output)
    {
        $laravel_config_file = getcwd().'/config/app.php';
        if (!file_exists($laravel_config_file)) {
            $output->writeln('<error>File '.$laravel_config_file.' doesn\'t exists');
        }
        if (!$this->configAppFileAlreadyInstalled()) {
            copy(__DIR__.'/stubs/app.php', $laravel_config_file);
        }
        $output->writeln('<infp>File '.$laravel_config_file.' updated correctly');
    }

    /**
     * Check if config/app.php stub file is already installed.
     *
     * @return bool
     */
    protected function configAppFileAlreadyInstalled()
    {
        if (strpos(file_get_contents(getcwd().'/config/app.php'), '#llum_providers') !== false) {
            return true;
        }

        return false;
    }

    protected function devtools(OutputInterface $output)
    {
        $this->installConfigAppFile($output);
        $error = $this->addLaravelIdeHelperProvider();
        if ($error) {
            $output->writeln('<error>Error adding Laravel ide helper provider</error>');
        } else {
            $output->writeln('<info>Laravel ide helper provider added to config/app.php file</info>');
        }
        $error = $this->addLaravelDebugbarProvider();
        if ($error) {
            $output->writeln('<error>Error adding Laravel Debugbar provider</error>');
        } else {
            $output->writeln('<info>Laravel Debugbar provider added to config/app.php file</info>');
        }
        $error = $this->addLaravelDebugbarAlias();
        if ($error) {
            $output->writeln('<error>Error adding Laravel Debugbar alias</error>');
        } else {
            $output->writeln('<info>Laravel Debugbar alias added to config/app.php file</info>');
        }

    }

    protected function addLaravelIdeHelperProvider()
    {
        return $this->addProvider('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class');
    }

    private function addLaravelDebugbarProvider()
    {
        return $this->addProvider('Barryvdh\Debugbar\ServiceProvider::class');
    }

    private function addLaravelDebugbarAlias()
    {
        return $this->addAlias("Debugbar", "Barryvdh\Debugbar\Facade::class");
    }

    private function addProvider($provider)
    {
        return $this->addTextIntoMountPoint('#llum_providers',$provider);
    }

    private function addAlias($alias,$aliasClass)
    {
        $mountpoint="#llum_aliases";
        passthru(
            'sed -i \'s/.*' . $mountpoint  . '.*/ \ \ \ \ \ \ \ \x27' . $alias . '\x27' . preg_quote(" => " . $aliasClass).',\n \ \ \ \ \ \ \ ' . $mountpoint . '/\' config/app.php', $error);

        return $error;
    }

    private function addTextIntoMountPoint($mountpoint,$textToAdd)
    {
        passthru(
            'sed -i \'s/.*' . $mountpoint  . '.*/ \ \ \ \ \ \ \ ' . preg_quote($textToAdd).',\n \ \ \ \ \ \ \ ' . $mountpoint . '/\' config/app.php', $error);

        return $error;
    }
}
