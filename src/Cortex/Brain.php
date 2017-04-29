<?php

namespace Vulcan\Rivescript\Cortex;

use SplFileObject;

class Brain
{
    /**
     * @var Branch
     */
    protected $topics;

    /**
     * Create a new instance of Brain.
     */
    public function __construct()
    {
        $this->createTopic('random');
    }

    /**
     * Teach the brain contents of a new file source.
     *
     * @param string $file
     */
    public function teach($file)
    {
        $commands = synapse()->commands;
        $file = new SplFileObject($file);
        $lineNumber = 0;

        while (!$file->eof()) {
            $currentCommand = null;
            $node = new Node($file->fgets(), $lineNumber++);

            if ($node->isInterrupted() or $node->isComment()) {
                continue;
            }

            $commands->each(function ($command) use ($node, $currentCommand) {
                $class = "\\Vulcan\\Rivescript\\Cortex\\Commands\\$command";
                $commandClass = new $class();

                $result = $commandClass->parse($node, $currentCommand);

                if (isset($result['command'])) {
                    $currentCommand = $result['command'];

                    return false;
                }
            });
        }
    }

    public function topic($name = null)
    {
        if (is_null($name)) {
            $name = synapse()->memory->shortTerm()->get('topic') ?: 'random';
        }

        return $this->topics[$name];
    }

    public function createTopic($name)
    {
        $this->topics[$name] = new Topic($name);

        return $this->topics[$name];
    }
}
