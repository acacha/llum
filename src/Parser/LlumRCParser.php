<?php

namespace Acacha\Llum\Parser;

/**
 * Class LlumRCParser.
 *
 * @package Acacha\Llum\Parser
 */
use Acacha\Llum\LlumRCFile;

/**
 * Class LlumRCParser
 * @package Acacha\Llum\Parser
 */
class LlumRCParser
{

    /**
     * File to parse.
     *
     * @var
     */
    protected $file;

    /**
     * LlumRCParser constructor.
     * @param $file
     */
    public function __construct(LlumRCFile $file)
    {
        $this->file = $file;
    }

    /**
     * Parse llumrc file.
     *
     * @return array
     */
    public function parse()
    {
        return parse_ini_file($this->file->path());
    }
}