<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Console\SqliteTouchCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SqliteCommandTest.
 */
class SqliteEnvCommandTest extends \PHPUnit_Framework_TestCase
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
     * test SqliteCommand.
     */
    public function testExecute()
    {
        $application = new Application();
        $application->add(new SqliteTouchCommand());

        $command = $application->find('sqlite:touch');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $this->assertRegExp('/successfully/', $commandTester->getDisplay());
        //$this->assert ('/.../', $commandTester->getStatusCode());
    }
}
