<?php

namespace Vulcan\Rivescript\Cortex;

use Vulcan\Collections\Collection;

class Memory
{
    /**
     * @var Collection
     */
    protected $shortTerm;

    /**
     * @var Collection
     */
    protected $substitute;

    /**
     * @var Collection
     */
    protected $variables;

    /**
     * Create a new Memory instance.
     */
    public function __construct()
    {
        $this->shortTerm = Collection::make([]);
        $this->substitute = Collection::make([]);
        $this->variables = Collection::make([]);
    }

    /**
     * Short-term memory cache.
     *
     * @return Collection
     */
    public function shortTerm()
    {
        return $this->shortTerm;
    }

    /**
     * Stored substitute variables.
     *
     * @return Collection
     */
    public function substitute()
    {
        return $this->substitute;
    }

    /**
     * Stored variables.
     *
     * @return Collection
     */
    public function variables()
    {
        return $this->variables;
    }
}
