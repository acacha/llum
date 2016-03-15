<?php

namespace Acacha\Llum\Console;

use Illuminate\Config\Repository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class LlumCommand.
 */
abstract class LlumCommand extends Command
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName;

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription;

    /**
     * Command argument.
     *
     * @var string
     */
    protected $argument;

    /**
     * Argument type.
     *
     * @var int
     */
    protected $argumentType = InputArgument::REQUIRED;

    /**
     * Command argument description.
     *
     * @var string
     */
    protected $argumentDescription;

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method;

    /**
     * Laravel config file (config/app.php).
     *
     * @var string
     */
    protected $laravel_config_file;

    /**
     * Path to config folder.
     *
     * @var string
     */
    protected $configPath;

    /**
     * Avoids using bash using stubs instead to modify config/app.php file.
     *
     * @var bool
     */
    protected $noBash = false;

    /**
     * Config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Executes boot command.
     *
     * @param OutputInterface $output
     */
    protected function boot(OutputInterface $output)
    {
        $this->devtools($output);
        $this->touchSqliteFile($output);
        $this->configEnv($output);
        $this->migrate($output);
        $this->serve($output);
    }

    /**
     * LlumCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->configPath = __DIR__.'/../config/';
        $this->laravel_config_file = getcwd().'/config/app.php';
        $this->config = $this->obtainConfig();
    }

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
                $output->writeln('<info>Running php artisan serve --port='.$port.'</info>');
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
        if (! $fp) {
            return true;
        } else {
            fclose($fp);

            return false;
        }
    }

    /**
     * Install /config/app.php file using bash script.
     */
    protected function installConfigAppFileWithBash()
    {
        passthru(__DIR__.'/../bash_scripts/iluminar.sh '.$this->laravel_config_file);
    }

    /**
     * Install /stubs/app.php into /config/app.php.
     */
    protected function installConfigAppFileWithStubs()
    {
        copy(__DIR__.'/stubs/app.php', $this->laravel_config_file);
    }

    /**
     * Check if Laravel config file exists.
     *
     * @return bool
     */
    protected function checkIfLaravelConfigFileExists()
    {
        return file_exists($this->laravel_config_file);
    }

    /**
     * Install llum custom config/app.php file.
     *
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function installConfigAppFile(OutputInterface $output)
    {
        if (! $this->checkIfLaravelConfigFileExists()) {
            $output->writeln('<error>File '.$this->laravel_config_file.' doesn\'t exists');

            return -1;
        }

        if ($this->configAppFileAlreadyInstalled()) {
            $output->writeln('<info>File '.$this->laravel_config_file.' already supports llum.</info>');

            return 0;
        }

        if ($this->isNoBashActive()) {
            $this->installConfigAppFileWithStubs();
            $output->writeln('<info>File '.$this->laravel_config_file.' overwrited correctly with and stub.</info>');
        } else {
            $this->installConfigAppFileWithBash();
        }

        return 0;
    }

    /**
     * Check if config/app.php stub file is already installed.
     *
     * @return bool
     */
    protected function configAppFileAlreadyInstalled()
    {
        if (strpos(file_get_contents($this->laravel_config_file), '#llum_providers') !== false) {
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
        $this->package($output, 'barryvdh/laravel-ide-helper');
    }

    /**
     * Install Laravel debugbar package.
     *
     * @param OutputInterface $output
     */
    protected function debugbar(OutputInterface $output)
    {
        $this->package($output, 'barryvdh/laravel-debugbar');
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
     * @return int|null
     */
    protected function addLaravelIdeHelperProvider()
    {
        return $this->addProvider('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class');
    }

    /**
     *  Add provider to config/app.php file.
     *
     * @param $provider
     *
     * @return int|null
     */
    private function addProvider($provider)
    {
        return $this->addTextIntoMountPoint('#llum_providers', $provider);
    }

    /**
     * Add alias to config/app.php file.
     *
     * @param string $alias
     *
     * @return int|null
     */
    private function addAlias($alias)
    {
        return $this->addTextIntoMountPoint('#llum_aliases', $alias);
    }

    /**
     * Insert text into file using mountpoint. Mountpoint is maintained at file.
     *
     * @param string $mountpoint
     * @param $textToAdd
     *
     * @return int|null
     */
    private function addTextIntoMountPoint($mountpoint, $textToAdd)
    {
        passthru(
            'sed -i \'s/.*'.$mountpoint.'.*/ \ \ \ \ \ \ \ '.$this->scapeSingleQuotes(preg_quote($textToAdd)).',\n \ \ \ \ \ \ \ '.$mountpoint.'/\' '.$this->laravel_config_file, $error);

        return $error;
    }

    /**
     * scape single quotes for sed using \x27.
     *
     * @param string $str
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
        $output->writeln('<info>Running composer require '.$package.'</info>');
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
        $output->writeln('<info>Running php artisan migrate...</info>');
        passthru('php artisan migrate');
    }

    /**
     * Installs provider in laravel config/app.php file.
     *
     * @param OutputInterface $output
     * @param $provider
     */
    protected function provider(OutputInterface $output, $provider)
    {
        if ($this->installConfigAppFile($output) == -1) {
            return;
        }
        $this->addProvider($provider);
    }

    /**
     * Installs alias/facade in laravel config/app.php file.
     *
     * @param OutputInterface $output
     * @param $aliasName
     * @param $aliasClass
     */
    protected function alias(OutputInterface $output, $aliasName, $aliasClass)
    {
        if ($this->installConfigAppFile($output) == -1) {
            return;
        }
        $this->addAlias("'".$aliasName."' => ".$aliasClass);
    }

    /**
     * Shows list of supported packages.
     *
     * @param OutputInterface $output
     */
    protected function packageList(OutputInterface $output)
    {
        $packages = $this->config->all();
        foreach ($packages as $name => $package) {
            $output->writeln('<info>'.$name.'</info> | '.$this->parsePackageInfo($package));
        }
    }

    /**
     * Parse package info.
     *
     * @param $package
     *
     * @return string
     */
    private function parsePackageInfo($package)
    {
        return 'Composer name: '.$package['name'];
    }

    /**
     * get package from config.
     *
     * @param $name
     *
     * @return array
     */
    private function getPackageFromConfig($name)
    {
        //Check if package name is a composer package name
        if (str_contains($name, '/')) {
            return $this->config->get($this->getPackageNameByComposerName($name));
        }

        return $this->config->get($name);
    }

    /**
     * Add providers to Laravel config file.
     *
     * @param $providers
     * @param OutputInterface $output
     */
    protected function addProviders($providers, $output)
    {
        foreach ($providers as $provider) {
            $output->writeln('<info>Adding '.$provider.' to Laravel config app.php file</info>');
            $this->addProvider($provider);
        }
    }

    /**
     * Add aliases to Laravel config file.
     *
     * @param $aliases
     * @param OutputInterface $output
     */
    protected function addAliases($aliases, $output)
    {
        foreach ($aliases as $alias => $aliasClass) {
            $output->writeln('<info>Adding '.$aliasClass.' to Laravel config app.php file</info>');
            $this->addAlias("'$alias' => ".$aliasClass);
        }
    }

    /**
     * Installs laravel package form config/packages.php file.
     *
     * @param OutputInterface $output
     * @param $name
     */
    protected function package(OutputInterface $output, $name)
    {
        $package = $this->getPackageFromConfig($name);

        if ($package == null) {
            $this->showPackageNotFoundError($output, $name);

            return;
        }

        list($name, $providers, $aliases, $after) = array_fill(0, 4, null);
        extract($package, EXTR_IF_EXISTS);

        $this->requireComposerPackage($output, $name);

        if ($this->installConfigAppFile($output) == -1) {
            return;
        }

        $this->addProviders($providers, $output);

        $this->addAliases($aliases, $output);

        if ($after != null) {
            passthru($after);
        }
    }

    /**
     * Get config repository.
     *
     * @return Repository
     */
    protected function obtainConfig()
    {
        return new Repository(require $this->configPath.'packages.php');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        if ($input->hasOption('no-bash')) {
            $this->noBash = $input->getOption('no-bash');
        }
    }

    /**
     * Check is --no-bash option is active.
     *
     * @return bool
     */
    private function isNoBashActive()
    {
        return $this->noBash;
    }

    /**
     * Get package name by composer package name.
     * 
     * @param $composerPackageName
     *
     * @return string
     */
    private function getPackageNameByComposerName($composerPackageName)
    {
        foreach ($this->config->all() as $key => $configItem) {
            if ($configItem['name'] == $composerPackageName) {
                return $key;
            }
        }

        return;
    }

    /**
     * Show package not found error.
     *
     * @param OutputInterface $output
     * @param $name
     */
    protected function showPackageNotFoundError(OutputInterface $output, $name)
    {
        $output->writeln('<error>Package '.$name.' not found in file '.$this->configPath.'packages.php</error>');

        return;
    }

    /**
     * Configure the command options.
     *
     * @param ConsoleCommand $command
     */
    protected function configureCommand(ConsoleCommand $command)
    {
        $this->ignoreValidationErrors();

        $this->setName($command->name())
            ->setDescription($command->description());
        if ($command->argument() != null) {
            $this->addArgument($command->argument()['name'],
                $command->argument()['type'],
                $command->argument()['description']
            );
        }
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $method = $this->method;
        if ($this->argument != null) {
            $argument = $input->getArgument($this->argument);
            $this->$method($output, $argument);

            return;
        }

        $this->$method($output);
    }

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $command = new ConsoleCommand();

        $command->name($this->commandName)
                ->description($this->commandDescription);

        if ($this->argument != null) {
            $command->argument([
                'name' => $this->argument,
                'description' => $this->argumentDescription,
                'type' => $this->argumentType,
            ]);
        }
        $this->configureCommand($command);
    }
}
