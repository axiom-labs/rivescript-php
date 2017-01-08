<?php

namespace Vulcan\Rivescript;

class Line
{
    /**
     * @var string
     */
    protected $line;

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
     * @var array
     */
    protected $blocks = [
        'Comment',
        'Command',
        'Value'
    ];

    /**
     * @var bool
     */
    protected $interrupted = false;

    /**
     * @var bool
     */
    protected $isComment = false;

    /**
     * Create a new Line instance.
     *
     * @param string  $line
     */
    public function __construct($line, $number)
    {
        $this->line   = $line;
        $this->number = $number;

        $this->process();
    }

    protected function process()
    {
        $this->line = remove_whitespace($this->line);

        foreach ($this->blocks as $block) {
            $this->{'block'.$block}();
        }
    }

    public function number()
    {
        return $this->number;
    }

    public function command()
    {
        return $this->command;
    }

    public function value()
    {
        return $this->value;
    }

    protected function blockComment()
    {
        if (starts_with($this->line, '//')) {
            $this->interrupted = true;
        } elseif (starts_with($this->line, '#')) {
            log_warning('Using the # symbol for comments is deprecated');
            $this->interrupted = true;
        } elseif (starts_with($this->line, '/*')) {
            if (ends_with($this->line, '*/')) return null;

            $this->isComment = true;
        } elseif (ends_with($this->line, '*/')) {
            $this->isComment = false;
        }
    }

    protected function blockCommand()
    {
        if (mb_strlen($this->line) === 0) {
            $this->interrupted = true;
            return;
        }

        $this->command = mb_substr($this->line, 0, 1);
    }

    protected function blockValue()
    {
        $this->value = trim(mb_substr($this->line, 1));
    }

    public function isComment()
    {
        return $this->isComment;
    }

    public function isInterrupted()
    {
        return $this->interrupted;
    }
}
