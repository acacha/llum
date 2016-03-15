<?php

namespace Acacha\Llum\Console;

/**
 * Class PackageListCommand.
 */
class PackageListCommand extends LlumCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $commandName = 'package:list';

    /**
     * Command description.
     *
     * @var string
     */
    protected $commandDescription = 'Shows available packages to list (info taken from config/packages.php)';

    /**
     * Method to execute.
     *
     * @var string
     */
    protected $method = 'packageList';

    /**
     * Shows list of supported packages.
     */
    protected function packageList()
    {
        $packages = $this->config->all();
        foreach ($packages as $name => $package) {
            $this->output->writeln('<info>'.$name.'</info> | '.$this->parsePackageInfo($package));
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
        return 'Composer name: '.$package[ 'name' ];
    }
}
