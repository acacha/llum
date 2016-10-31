<?php

namespace Acacha\Llum\Tests;
use Acacha\Llum\LlumRCFile;
use Acacha\Llum\Parser\LlumRCParser;

/**
 * Class LlumRCParserTest.
 */
class LlumRCParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * create sample RC file from stub.
     */
    protected function createsampleRCFile()
    {
        copy(__DIR__ .'/stubs/llumrc.stub', getenv("HOME") . '/.llumrc');
    }
    
    /**
     * test testFileIsParsedCorrectly.
     */
    public function testFileIsParsedCorrectly()
    {
        $this->createsampleRCFile();

        $parser = new LlumRCParser(new LlumRCFile());
        $result = $parser->parse();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('username', $result);
        $this->assertArrayHasKey('token', $result);

    }

    /**
     * test get credentials.
     */
    public function testGetCredentials()
    {
        $this->createsampleRCFile();

        $parser = new LlumRCParser(new LlumRCFile());
        $credentials = $parser->getCredentials();
        $this->assertTrue(is_array($credentials));
        $this->assertEquals('acacha', $credentials[0]);
        $this->assertEquals('abcdefgh12345678', $credentials[1]);
    }
}
