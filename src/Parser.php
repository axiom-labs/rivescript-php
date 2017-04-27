<?php

namespace Vulcan\Rivescript;

use SplFileObject;

class Parser
{
    protected $tree = [
        'begin' => [
            'global'  => [],
            'var'     => [],
            'sub'     => [],
            'person'  => [],
            'array'   => [],
        ],
        'topics'   => [],
        'objects'  => [],
        'metadata' => [
            'topic'   => 'random',
            'trigger' => null,
            'object'  => null,
            'input'   => [],
            'reply'   => [],
        ],
    ];

    protected $trigger;

    protected $commands = [
        'Arr',
        'ObjectMacro',
        'Topic',
        'Trigger',
        'Response',
        'Redirect',
        'Variable',
        'VariableGlobal',
        'VariablePerson',
        'VariableSubstitute',
    ];

    /**
     * Process Rivescript file.
     *
     * @param string     $file
     * @param array|null $tree
     *
     * @return array
     */
    public function process($file, $tree = null)
    {
        $this->setTree($tree);

        $file = new SplFileObject($file);
        $lineNumber = 1;

        while (!$file->eof()) {
            $currentCommand = null;
            $line = new Line($file->fgets(), $lineNumber++);

            if ($line->isInterrupted() or $line->isComment()) {
                continue;
            }

            foreach ($this->commands as $class) {
                $class = "\\Vulcan\\Rivescript\\Commands\\$class";
                $commandClass = new $class();

                $result = $commandClass->parse($this->tree, $line, $currentCommand);

                if (isset($result['command'])) {
                    $currentCommand = $result['command'];
                    continue 2;
                }

                $this->tree = $result['tree'];
            }
        }

        $file = null;

        $this->trimTree();

        dd($this->tree);

        return $this->tree;
    }

    protected function trimTree()
    {
        $this->tree['metadata']['trigger'] = null;
        $this->tree['metadata']['object'] = null;
    }

    private function setTree($tree)
    {
        if (!is_null($tree)) {
            $this->tree = $tree;
        }
    }
}
