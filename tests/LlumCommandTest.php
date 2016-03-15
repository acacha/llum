<?php

namespace Acacha\Llum\Tests;

/**
 * Class ConfigCommandTest.
 */
abstract class LlumCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check file config/app.php has content.
     *
     * @param $content
     * @return bool
     */
    protected function laravelConfigFileHasContent($content)
    {
        return $this->fileHasContent('/config/app.php', $content);
    }

    /**
     * Check if file has an specific content.
     *
     * @param $file
     * @param $content
     * @return bool
     */
    protected function fileHasContent($file, $content)
    {
        return strpos(file_get_contents(getcwd().$file), $content) != false;
    }
}
