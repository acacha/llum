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
    /**
     * Setup test.
     */
    protected function setUp()
    {
        passthru('mkdir config');
        passthru('cp src/Console/stubs/services.php.original config/services.php');
        passthru('cp src/Console/stubs/app_original.php config/app.php');
    }

    /**
     * Tear down test.
     */
    protected function tearDown()
    {
        //       passthru('rm -rf config');
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

    /**
     * test DevToolsCommand.
     */
    public function testExecuteWithOutputFileOption()
    {
        $application = new Application();
        $application->add(new ServiceCommand());

        $command = $application->find('service');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'file' => __DIR__.'/stubs/socialite_services',
            '--output-file' => 'config/services-output-file.php', ], ['verbosity']);

        $this->assertFileExists('config/services-output-file.php');
        $this->assertTrue(
            $this->laravelServicesFileHasContent('#llum_services', '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'github'", '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'facebook'", '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'google'", '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'twitter'", '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'GITHUB_CLIENT_ID'", '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'FACEBOOK_CLIENT_ID'", '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'GOOGLE_CLIENT_ID'", '/config/services-output-file.php')
        );
        $this->assertTrue(
            $this->laravelServicesFileHasContent("'TWITTER_CLIENT_ID'", '/config/services-output-file.php')
        );
    }

    /**
     * Check if Laravel Services File has an specific content.
     *
     * @param $content
     * @return bool
     */
    private function laravelServicesFileHasContent($content, $servicesFile = '/config/services.php')
    {
        return $this->fileHasContent($servicesFile, $content);
    }

    /**
     * Check if file as specific content.
     * @param $file
     * @param $content
     * @return bool
     */
    private function fileHasContent($file, $content)
    {
        return strpos(file_get_contents(getcwd().$file), $content) != false;
    }
}
