<?php

namespace Vulcan\Rivescript\Cortex;

use Vulcan\Collections\Collection;

class Memory
{
    /**
     * @var Collection
     */
    protected $person;

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
     * @var Collection
     */
    protected $user;

    /**
     * Create a new Memory instance.
     */
    public function __construct()
    {
        $this->shortTerm  = Collection::make([]);
        $this->substitute = Collection::make([]);
        $this->variables  = Collection::make([]);
        $this->person     = Collection::make([]);
        $this->user       = Collection::make([]);
    }

    /**
     * Stored person variables.
     *
     * @return Collection
     */
    public function person()
    {
        return $this->person;
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

    /**
     * Stored user data.
     *
     * @return Collection
     */
    public function user($user = 0)
    {
        if (! $this->user->has($user)) {
            $data = new Collection([]);

            $this->user->put($user, $data);
        }

        return $this->user->get($user);
    }
}
