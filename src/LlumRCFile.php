<?php

namespace Acacha\Llum;

class LlumRCFile {

    /**
     * Relative path to llumrc file.
     *
     * @var string
     */
    protected $relative_file_path = "/.llumrc";

    /**
     * Get real path (form user home)
     *
     * @return string
     */
    public function path()
    {
        return getenv("HOME") . $this->relative_file_path;
    }
}