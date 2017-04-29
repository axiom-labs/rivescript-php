<?php

namespace Vulcan\Rivescript\Cortex;

class Synapse
{
    /**
     * Object hash map.
     *
     * @var array
     */
    private $map = [];

    /**
     * Static instance object.
     *
     * @var object
     */
    public static $instance;

    /**
     * Construct a new Synapse instance.
     */
    public function __construct()
    {
        self::$instance = $this;
    }

    /**
     * Get the Synapse instance object.
     *
     * @return object
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Magic __set method.
     *
     * @return void
     */
    public function __set($key, $value)
    {
        $this->map[$key] = $value;
    }

    /**
     * Magic __get method.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->map[$key];
    }
}
