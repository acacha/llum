<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Compiler\RCFileCompiler;
use Acacha\Llum\Console\InitCommand;
use Acacha\Llum\Filesystem\Filesystem;
use Acacha\Llum\Github\GithubAPI;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

include __DIR__ . "/../passwords.php";

/**
 * Class InitCommandTest.
 */
class InitCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * test testFileIsParsedCorrectly.
     */
    public function testInitCommand()
    {
        $application = new Application();
        $application->add(new InitCommand( new Filesystem(), new RCFileCompiler(), new GithubAPI()));

        $command = $application->find('init');
        $commandTester = new CommandTester($command);
        $helper = $command->getHelper('question');
        $helper->setInputStream($this->getInputStream("acacha\ny\n" . GITHUB_PASSWORD));
        $commandTester->execute(['command' => $command->getName()]);

        var_dump($commandTester->getDisplay());
//        $this->assertContains('Username: Wouter', $output);
    }

    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }
}
