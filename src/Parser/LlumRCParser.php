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

    /**
     * Get credentials from config file.
     *
     * @return array
     */
    public function getCredentials()
    {
        $rc_file = $this->parse();
        if ( array_key_exists('username',$rc_file) && array_key_exists('username',$rc_file)) {
            return [$rc_file['username'],$rc_file['token']];
        }
    }

    /**
     * Get github username from config file.
     *
     * @return array
     */
    public function getGitHubUsername()
    {
        $rc_file = $this->parse();
        if ( array_key_exists('username',$rc_file)) {
            return $rc_file['username'];
        }
    }


}