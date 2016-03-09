<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

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
        if ($error  !== 0) {
            $output->writeln('<error>Error creating file'.$file.'</error>');
        } else {
            $output->writeln('<info>File '.$file.' created successfully</info>');
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
        if ($error !== 0) {
            $output->writeln('<error>Error commenting DB_ entries in .env file </error>');
        }
        passthru('sed -i \'s/.*DB_HOST.*/DB_CONNECTION=sqlite\n&/\' .env', $error);
        if ($error !== 0) {
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
            if ($this->check_port($port)) {
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
     *
     * @param OutputInterface $output
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
        $output->writeln('<info>File '.$laravel_config_file.' updated correctly</info>');
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

    /**
     *  Install Laravel ide helper package.
     *
     * @param OutputInterface $output
     */
    protected function idehelper(OutputInterface $output)
    {
        $this->requireComposerPackage($output, 'barryvdh/laravel-ide-helper');
        $this->installConfigAppFile($output);

        $error = $this->addLaravelIdeHelperProvider();
        if ($error !== 0) {
            $output->writeln('<error>Error adding Laravel ide helper provider</error>');
        } else {
            $output->writeln('<info>Laravel ide helper provider added to config/app.php file</info>');
        }

        passthru('php artisan ide-helper:generate');
    }

    /**
     * Install Laravel debugbar package.
     *
     * @param OutputInterface $output
     */
    protected function debugbar(OutputInterface $output)
    {
        $this->installConfigAppFile($output);
        $this->requireComposerPackage($output, 'barryvdh/laravel-debugbar');

        $error = $this->addLaravelDebugbarProvider();
        if ($error  !== 0) {
            $output->writeln('<error>Error adding Laravel Debugbar provider</error>');
        } else {
            $output->writeln('<info>Laravel Debugbar provider added to config/app.php file</info>');
        }
        $error = $this->addLaravelDebugbarAlias();
        if ($error  !== 0) {
            $output->writeln('<error>Error adding Laravel Debugbar alias</error>');
        } else {
            $output->writeln('<info>Laravel Debugbar alias added to config/app.php file</info>');
        }

        passthru('php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"');
    }

    /**
     * Execute devtools command.
     *
     * @param OutputInterface $output
     */
    protected function devtools(OutputInterface $output)
    {
        $this->idehelper($output);
        $this->debugbar($output);
    }

    /**
     * Add Laravel IDE Helper provider to config/app.php file.
     *
     * @return mixed
     */
    protected function addLaravelIdeHelperProvider()
    {
        return $this->addProvider('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class');
    }

    /**
     * Add Laravel Debugbar provider to config/app.php file.
     *
     * @return mixed
     */
    private function addLaravelDebugbarProvider()
    {
        return $this->addProvider('Barryvdh\Debugbar\ServiceProvider::class');
    }

    /**
     * Add Laravel Debugbar alias to config/app.php file.
     *
     * @return mixed
     */
    private function addLaravelDebugbarAlias()
    {
        return $this->addAlias("'Debugbar' => Barryvdh\Debugbar\Facade::class");
    }

    /**
     *  Add provider to config/app.php file.
     *
     * @param $provider
     *
     * @return mixed
     */
    private function addProvider($provider)
    {
        return $this->addTextIntoMountPoint('#llum_providers', $provider);
    }

    /**
     * Add alias to config/app.php file.
     *
     * @param $alias
     *
     * @return mixed
     */
    private function addAlias($alias)
    {
        return $this->addTextIntoMountPoint('#llum_aliases', $alias);
    }

    /**
     * Insert text into file using mountpoint. Mountpoint is maintained at file.
     *
     * @param $mountpoint
     * @param $textToAdd
     *
     * @return mixed
     */
    private function addTextIntoMountPoint($mountpoint, $textToAdd)
    {
        passthru(
            'sed -i \'s/.*'.$mountpoint.'.*/ \ \ \ \ \ \ \ '.$this->scapeSingleQuotes(preg_quote($textToAdd)).',\n \ \ \ \ \ \ \ '.$mountpoint.'/\' config/app.php', $error);

        return $error;
    }

    /**
     * scape single quotes for sed using \x27.
     *
     * @param $str
     *
     * @return mixed
     */
    private function scapeSingleQuotes($str)
    {
        return str_replace("'", '\\x27', $str);
    }

    /**
     * @param OutputInterface $output
     * @param $package
     */
    private function requireComposerPackage(OutputInterface $output, $package)
    {
        $composer = $this->findComposer();

        $process = new Process($composer.' require '.$package.'', null, null, null, null);
        $output->writeln('<info>Executing composer require '.$package.'</info>');
        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    private function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" composer.phar"';
        }

        return 'composer';
    }

    /**
     * Migrate database with php artisan migrate.
     *
     * @param $output
     */
    protected function migrate(OutputInterface $output)
    {
        passthru('php artisan migrate');
    }

    /**
     * Installs provider in laravel config/app.php file.
     *
     * @param OutputInterface $output
     */
    protected function provider(OutputInterface $output, $provider)
    {
        $this->installConfigAppFile($output);
        $this->addProvider($provider);
    }
}
