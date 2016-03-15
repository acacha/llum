<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Console\ConfigCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ConfigCommandTest.
 */
class ConfigCommandTest extends LlumCommandTest
{
    protected function setUp()
    {
        passthru('./test_setup.sh');
    }

    protected function tearDown()
    {
        passthru('./test_teardown.sh');
    }

    /**
     * @group failing
     * test DevToolsCommand
     */
    public function testExecute()
    {
        $application = new Application();
        $application->add(new ConfigCommand());

        $command = $application->find('config');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            ]
        );

        $this->assertTrue(
            $this->fileHasContent('/config/app.php', '#llum_providers')
        );
        $this->assertTrue(
            $this->fileHasContent('/config/app.php', '#llum_aliases')
        );
    }
}
