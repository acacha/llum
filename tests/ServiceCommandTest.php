<?php

namespace Acacha\Llum\Tests;

use Acacha\Llum\Console\ServiceCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ServiceCommandTest.
 */
class ServiceCommandTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        passthru('mkdir config');
        passthru('cp src/Console/stubs/services.php.original config/services.php');
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
        $application->add(new ServiceCommand());

        $command = $application->find('service');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'file' => __DIR__.'/stubs/socialite_services', ]);

        $this->assertFileExists('config/services.php');
        $this->assertTrue(
            $this->laravelServicesFileHasContent('#llum_services')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'github'")
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'facebook'")
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'google'")
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'twitter'")
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'GITHUB_CLIENT_ID'")
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'FACEBOOK_CLIENT_ID'")
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'GOOGLE_CLIENT_ID'")
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'TWITTER_CLIENT_ID'")
        );
    }

    private function laravelServicesFileHasContent($content)
    {
        return $this->fileHasContent('/config/services.php', $content);
    }

    private function fileHasContent($file, $content)
    {
        return strpos(file_get_contents(getcwd().$file), $content) != false;
    }
}
