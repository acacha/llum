<?php

namespace Acacha\Llum\Console;

use Acacha\Llum\Traits\GetSetable;

/**
 * Class ConsoleCommand.
 */
class ConsoleCommand
{
    use GetSetable;

    /**
     * Command name.
     *
     * @var string
     */
    protected $name;

    /**
     * Command description.
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
     * @param null | string $name
     *
     * @return ConsoleCommand | string
     */
    public function name($name = null)
    {
        return $this->getterSetter('name', $name);
    }

    /**
     * Set/get description.
     *
     * @param null | string $description
     *
     * @return ConsoleCommand | string
     */
    public function description($description = null)
    {
        return $this->getterSetter('description', $description);
    }

    /**
     * Set/get argument.
     *
     * @param array | null $argument
     *
     * @return ConsoleCommand | string
     */
    public function argument($argument = null)
    {
        return $this->getterSetter('argument', $argument);
    }
}
