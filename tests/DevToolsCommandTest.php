<?php

use Acacha\Llum\Console\DevToolsCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class DevToolsCommandTest
 */
class DevToolsCommandTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        passthru('mkdir config');
        passthru('cp src/Console/stubs/app_original.php config/app.php');
    }

    protected function tearDown()
    {
//        passthru('rm -rf config');
    }

    /**
     * test DevToolsCommand
     */
    public function testExecute()
    {
        $application = new Application();
        $application->add(new DevToolsCommand());

        $command = $application->find('devtools');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertFileExists('config/app.php');
        $this->assertTrue(
            $this->fileHasContent('#llum_providers')
        );
        $this->assertTrue(
            $this->fileHasContent('#llum_aliases')
        );
        $this->assertTrue(
            $this->fileHasContent('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class')
        );

        $this->assertTrue(
            $this->fileHasContent('Barryvdh\Debugbar\ServiceProvider::class')
        );

        $this->assertTrue(
            $this->fileHasContent("'Debugbar' => Barryvdh\Debugbar\Facade::class")
        );




        //$this->assertRegExp('/successfully/', $commandTester->getDisplay());
        //$this->assert ('/.../', $commandTester->getStatusCode());

    }

    private function fileHasContent($content) {
        return strpos(file_get_contents(getcwd().'/config/app.php'), $content) != false;
    }
}