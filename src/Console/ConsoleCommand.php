<?php

namespace Acacha\Llum\Console;

/**
 * Class ConsoleCommand.
 */
class ConsoleCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $name;

    /**
     * Command name.
     *
     * @var string
     */
    protected $description;

    /**
     * Command argument.
     *
     * @var array
     */
    protected $argument;

    /**
     * Set/get name.
     *
     * @param null $name
     *
     * @return mixed
     */
    public function name($name = null)
    {
        if ($name == null) {
            return $this->name;
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Set/get description.
     *
     * @param null $description
     *
     * @return mixed
     */
    public function description($description = null)
    {
        if ($description == null) {
            return $this->description;
        }

        $this->description = $description;

        return $this;
    }

    /**
     * Set/get argument.
     *
     * @param null $argument
     *
     * @return mixed
     */
    public function argument($argument = null)
    {
        if ($argument == null) {
            return $this->argument;
        }

        $this->argument = $argument;

        return $this;
    }
}
