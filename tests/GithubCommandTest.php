<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Console\GithubCommand;
use Acacha\Llum\Console\GithubInitCommand;
use Acacha\Llum\Console\GithubRepoCommand;
use Acacha\Llum\Filesystem\Filesystem;
use Acacha\Llum\Github\GithubAPI;
use Acacha\Llum\LlumRCFile;
use Acacha\Llum\Parser\LlumRCParser;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

include __DIR__ . "/../passwords.php";

/**
 * Class GithubCommandTest.
 */
class GithubCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * test testFileIsParsedCorrectly.
     */
    public function testGithubAuth()
    {
        $application = new Application();
        $application->add(new GithubCommand( new Filesystem(), new GithubAPI()));

        $command = $application->find('github');
        $commandTester = new CommandTester($command);
        $helper = $command->getHelper('question');
        $commandTester->execute(['command' => $command->getName()]);

        var_dump($commandTester->getDisplay());

    }

    /**
     * test testGithubCreateRepo command.
     */
    public function testGithubCreateRepo()
    {
        $application = new Application();
        $application->add(
            new GithubRepoCommand(
                new GithubAPI(
                    new Filesystem()
                ),
                new LlumRCParser(
                    new LlumRCFile()
                )
            ));
        $command = $application->find('github:repo');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        var_dump($commandTester->getDisplay());

    }

    /**
     * test testGithubInitRepo command.
     * @group failing
     */
    public function testGithubInitRepo()
    {
        $application = new Application();
        $application->add(new GithubInitCommand());

        $command = $application->find('github:init');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        var_dump($commandTester->getDisplay());
    }

}
