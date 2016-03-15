<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Console\SqliteEnvCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SqliteCommandTest.
 */
class SqliteTouchCommandTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        passthru('cp src/Console/stubs/.env .');
    }

    protected function tearDown()
    {
        passthru('rm -rf .env');
    }

    /**
     * test SqliteCommand.
     */
    public function testExecute()
    {
        $application = new Application();
        $application->add(new SqliteEnvCommand());

        $command = $application->find('sqlite:env');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $this->assertRegExp('/successfully/', $commandTester->getDisplay());
        //$this->assert ('/.../', $commandTester->getStatusCode());
    }
}
