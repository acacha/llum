<?php

use Acacha\Llum\Console\SqliteCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SqliteCommandTest
 */
class SqliteCommandTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        passthru('mkdir database');
    }

    protected function tearDown()
    {
        passthru('rm -rf database');
    }

    /**
     * test SqliteCommand
     */
    public function testExecute()
    {
        $application = new Application();
        $application->add(new SqliteCommand());

        $command = $application->find('sqlite');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/successfully/', $commandTester->getDisplay());
        //$this->assert ('/.../', $commandTester->getStatusCode());

    }
}