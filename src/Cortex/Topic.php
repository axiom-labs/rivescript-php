<?php

namespace Vulcan\Rivescript\Cortex;

use Vulcan\Collections\Collection;

class Topic
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    public $triggers;

    /**
     * Create a new Branch instance.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->triggers = new Collection([]);
    }

    /**
     * Return triggers associated with this branch.
     *
     * @return array
     */
    public function triggers()
    {
        return $this->triggers;
    }

    public function setTriggers($triggers)
    {
        $this->triggers = $triggers;
    }
}
