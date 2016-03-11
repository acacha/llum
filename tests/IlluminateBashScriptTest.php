<?php

use Acacha\Llum\Console\SqliteTouchCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class IlluminateBashScriptTest
 */
class IlluminateBashScriptTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @group failing
     * test IlluminateBashScriptTest
     */
    public function testExecute()
    {
        passthru( __DIR__ . '/../test.sh | grep -Fq "#llum_providers"',$return_value);
        $this->assertEquals($return_value,0);
    }
}