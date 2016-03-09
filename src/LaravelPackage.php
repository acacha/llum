<?php

namespace Acacha\Llum;

use JsonSerializable;

/**
 * Class LaravelPackage.
 */
class LaravelPackage implements JsonSerializable
{
    /**
     * Laravel package's composer name.
     *
     * @var
     */
    protected $name;

    /**
     * Laravel package's composer name.
     *
     * @var
     */
    protected $composerName;

    /**
     * Laravel providers.
     *
     * @var array
     */
    protected $providers = [];

    /**
     * Laravel aliases/facades.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * LaravelPackage constructor.
     *
     * @param $name
     * @param array $providers
     * @param array $aliases
     */
    public function __construct($name = null, array $providers = [], array $aliases = [])
    {
        $this->name = $name;
        $this->providers = $providers;
        $this->aliases = $aliases;
    }

    /**
     * Fluent set/get name.
     *
     * @param null $name
     *
     * @return $this
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
     * Fluent set/get name.
     *
     * @param null $name
     *
     * @return $this
     */
    public function composerName($composerName = null)
    {
        if ($composerName == null) {
            return $this->composerName;
        }

        $this->composerName = $composerName;

        return $this;
    }

    /**
     * Fluent set/get providers.
     *
     * @param null $providers
     *
     * @return $this
     */
    public function providers($providers = null)
    {
        if ($providers == null) {
            return $this->$providers;
        }

        $this->providers = $providers;

        return $this;
    }

    /**
     * Fluent set/get aliases.
     *
     * @param null $aliases
     *
     * @return $this
     */
    public function aliases($aliases = null)
    {
        if ($aliases == null) {
            return $this->$aliases;
        }

        $this->aliases = $aliases;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
