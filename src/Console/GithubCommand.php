<?php

namespace Acacha\Llum\Console;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GithubCommand.
 *
 * @package Acacha\Llum\Console
 */
trait GithubCommand
{

    /**
     * Show error run llum init first.
     *
     * @param OutputInterface $output
     * @param $varname
     */
    protected function showErrorRunLlumInitFirst(OutputInterface $output, $varname)
    {
        $output->writeln('<error>' . $varname
            . ' not found in config file. Run git init before executing this command!</error>');
        die();
    }

    /**
     * Show message running command.
     *
     * @param OutputInterface $output
     */
    protected function showMessageRunningCommand(OutputInterface $output, $commandName) {
        $output->writeln('<info>Running command ' . $commandName . '...</info>');
    }
}