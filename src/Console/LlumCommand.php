<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Exceptions\InvalidCommandException;
use Acacha\Llum\Traits\LaravelConfigFile;
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
    use LaravelConfigFile;

    /**
     * The output interface.
     *
     * @var OutputInterface
     */
    protected $output;

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
     * Laravel services file (config/services.php).
     *
     * @var string
     */
    protected $laravel_services_file;

    /**
     * Path to config folder.
     *
     * @var string
     */
    protected $configPath;

    /**
     * Config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * LlumCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->configPath = __DIR__.'/../config/';
        $this->laravel_config_file = getcwd().'/config/app.php';
        $this->laravel_services_file = getcwd().'/config/services.php';
        $this->config = $this->obtainConfig();
    }

    /**
     * Require composer package.
     *
     * @param $package
     */
    private function requireComposerPackage($package)
    {
        $composer = $this->findComposer();

        $process = new Process($composer.' require '.$package.'', null, null, null, null);
        $this->output->writeln('<info>Running composer require '.$package.'</info>');
        $process->run(function ($type, $line) {
            $this->output->write($line);
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
     * Installs laravel package form config/packages.php file.
     *
     * @param string $name
     * @return int -1 if error occurred
     */
    protected function package($name)
    {
        $package = $this->obtainPackage($name);

        if ($package == -1) {
            return;
        }

        list($name, $providers, $aliases, $after) = array_fill(0, 4, null);
        extract($package, EXTR_IF_EXISTS);

        $this->requireComposerPackage($name);

        if ($this->setupLaravelConfigFile($providers, $aliases) == -1) {
            return -1;
        }

        $this->executeScriptAfterPackageInstallation($after);
    }

    /**
     * Obtain package.
     *
     * @param $name
     * @return array|int
     */
    private function obtainPackage($name)
    {
        $package = $this->getPackageFromConfig($name);

        if ($package == null) {
            $this->showPackageNotFoundError($name);

            return -1;
        }

        return $package;
    }

    /**
     * Execute post package installation script.
     *
     * @param $after
     */
    private function executeScriptAfterPackageInstallation($after)
    {
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
     * Get package name by composer package name.
     * 
     * @param $composerPackageName
     *
     * @return string
     */
    private function getPackageNameByComposerName($composerPackageName)
    {
        foreach ($this->config->all() as $key => $configItem) {
            if ($configItem[ 'name' ] == $composerPackageName) {
                return $key;
            }
        }

        return;
    }

    /**
     * Show package not found error.
     *
     * @param $name
     */
    protected function showPackageNotFoundError($name)
    {
        $this->output->writeln('<error>Package '.$name.' not found in file '.$this->configPath.'packages.php</error>');

        return;
    }

    /**
     * Configure the command options.
     *
     * @param ConsoleCommand $command
     * @throws \Acacha\Llum\Exceptions\InvalidCommandException
     */
    protected function configureCommand(ConsoleCommand $command)
    {
        $this->ignoreValidationErrors();

        $name = $command->name();
        $description = $command->description();

        if (! is_string($name) || ! is_string($description)) {
            throw new InvalidCommandException;
        }

        $this->setName($name)
             ->setDescription($description);
        if ($command->argument() != null) {
            $this->addArgument($command->argument()[ 'name' ],
                $command->argument()[ 'type' ],
                $command->argument()[ 'description' ]
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
        $this->output = $output;
        $method = $this->method;
        if ($this->argument != null) {
            $argument = $input->getArgument($this->argument);
            $this->$method($argument);

            return;
        }

        $this->$method();
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
