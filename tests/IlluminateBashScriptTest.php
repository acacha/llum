<?php

namespace Acacha\Llum\Tests;

/**
 * Class IlluminateBashScriptTest.
 */
class IlluminateBashScriptTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test IlluminateBashScriptTest.
     */
    public function testExecute()
    {
        passthru(__DIR__.'/../test.sh | grep -Fq "#llum_providers"', $return_value);
        $this->assertEquals($return_value, 0);
    }
}
