<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Console\ProviderCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ProviderCommandTest.
 */
class ProviderCommandTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        passthru('mkdir config');
        passthru('cp src/Console/stubs/app_original.php config/app.php');
    }

    protected function tearDown()
    {
        passthru('rm -rf config');
    }

    /**
     * test DevToolsCommand.
     */
    public function testExecute()
    {
        $application = new Application();
        $application->add(new ProviderCommand());

        $command = $application->find('provider');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'provider' => 'Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider::class', ]);

        $this->assertFileExists('config/app.php');
        $this->assertTrue(
            $this->laravelConfigFileHasContent('#llum_providers')
        );
        $this->assertTrue(
            $this->laravelConfigFileHasContent('#llum_aliases')
        );
        $this->assertTrue(
            $this->laravelConfigFileHasContent('Acacha\AdminLTETemplateLaravel\app\Providers\AdminLTETemplateServiceProvider::class')
        );
    }

    private function laravelConfigFileHasContent($content)
    {
        return $this->fileHasContent('/config/app.php', $content);
    }

    private function fileHasContent($file, $content)
    {
        return strpos(file_get_contents(getcwd().$file), $content) != false;
    }
}
