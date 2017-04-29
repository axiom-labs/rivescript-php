<?php

namespace Vulcan\Rivescript\Cortex;

class Node
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var int
     */
    protected $number;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var bool
     */
    protected $isInterrupted = false;

    /**
     * @var bool
     */
    protected $isComment = false;

    /**
     * Create a new Source instance.
     *
     * @param string $source
     * @param int    $number
     */
    public function __construct($source, int $number)
    {
        $this->source = remove_whitespace($source);
        $this->number = $number;

        $this->determineComment();
        $this->determineCommand();
        $this->determineValue();
    }

    /**
     * Returns the node's command trigger.
     *
     * @return string
     */
    public function command()
    {
        return $this->command;
    }

    /**
     * Returns the node's value.
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Returns the node's line number.
     *
     * @return int
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * Returns true if node is a comment.
     *
     * @return bool
     */
    public function isComment()
    {
        return $this->isComment;
    }

    /**
     * Returns true is node has been interrupted.
     *
     * @return bool
     */
    public function isInterrupted()
    {
        return $this->isInterrupted;
    }

    /**
     * Determine the command type of the node.
     *
     * @return void
     */
    protected function determineCommand()
    {
        if (mb_strlen($this->source) === 0) {
            $this->isInterrupted = true;

            return;
        }

        $this->command = mb_substr($this->source, 0, 1);
    }

    /**
     * Determine if the current node source is a comment.
     *
     * @return void
     */
    protected function determineComment()
    {
        if (starts_with($this->source, '//')) {
            $this->isInterrupted = true;
        } elseif (starts_with($this->source, '#')) {
            log_warning('Using the # symbol for comments is deprecated');
            $this->isInterrupted = true;
        } elseif (starts_with($this->source, '/*')) {
            if (ends_with($this->source, '*/')) {
                return;
            }
            $this->isComment = true;
        } elseif (ends_with($this->source, '*/')) {
            $this->isComment = false;
        }
    }

    /**
     * Determine the value of the node.
     *
     * @return void
     */
    protected function determineValue()
    {
        $this->value = trim(mb_substr($this->source, 1));
    }
}
