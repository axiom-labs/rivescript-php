<?php

namespace Vulcan\Rivescript\Cortex;

class Input
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $original;

    /**
     * @var int|null
     */
    protected $user;

    /**
     * Create a new Input instance.
     *
     * @param string   $source
     * @param int|null $user
     */
    public function __construct($source, $user = null)
    {
        $this->original = $source;
        $this->user     = $user;

        $this->cleanOriginalSource();
    }

    /**
     * Return the source input.
     *
     * @return string
     */
    public function source()
    {
        return $this->source;
    }

    /**
     * Return the current user speaking.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Clean the source input, so its in a state easily readable
     * by the interpreter.
     *
     * @return void
     */
    protected function cleanOriginalSource()
    {
        $patterns     = synapse()->memory->substitute()->keys()->all();
        $replacements = synapse()->memory->substitute()->values()->all();

        $this->source = mb_strtolower($this->original);
        $this->source = preg_replace($patterns, $replacements, $this->source);
        $this->source = preg_replace('/[^\pL\d\s]+/u', '', $this->source);
        $this->source = remove_whitespace($this->source);
    }
}
