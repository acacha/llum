<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Console\DevToolsCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class DevToolsCommandTest.
 */
class DevToolsCommandTest extends LlumCommandTest
{
    protected function setUp()
    {
        passthru('mkdir config');
        passthru('cp src/Console/stubs/app_original.php config/app.php');
    }

    protected function tearDown()
    {
        passthru('rm -rf config');
        passthru('composer remove barryvdh/laravel-ide-helper');
        passthru('composer remove barryvdh/laravel-debugbar');
    }

    /**
     * test DevToolsCommand.
     */
    public function testExecute()
    {
        $application = new Application();
        $application->add(new DevToolsCommand());

        $command = $application->find('devtools');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $this->assertTrue(
            $this->fileHasContent('/composer.json', 'barryvdh/laravel-ide-helper')
        );

        $this->assertTrue(
            $this->fileHasContent('/composer.json', 'barryvdh/laravel-debugbar')
        );

        $this->assertFileExists('vendor/barryvdh/laravel-debugbar');
        $this->assertFileExists('vendor/barryvdh/laravel-ide-helper');

        $this->assertFileExists('config/app.php');
        $this->assertTrue(
            $this->laravelConfigFileHasContent('#llum_providers')
        );
        $this->assertTrue(
            $this->laravelConfigFileHasContent('#llum_aliases')
        );
        $this->assertTrue(
            $this->laravelConfigFileHasContent('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class')
        );

        $this->assertTrue(
            $this->laravelConfigFileHasContent('Barryvdh\Debugbar\ServiceProvider::class')
        );

        $this->assertTrue(
            $this->laravelConfigFileHasContent("'Debugbar' => Barryvdh\Debugbar\Facade::class")
        );
    }
}
