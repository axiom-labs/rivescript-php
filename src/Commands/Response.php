<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class Response implements Command
{
    /**
     * Parse the command.
     *
     * @param array  $tree
     * @param object $line
     * @param string $command
     *
     * @return array
     */
    public function parse($tree, $line, $command)
    {
        if ($line->command() === '-') {
            $topic = $tree['metadata']['topic'];
            $key = $tree['metadata']['trigger']['key'];
            $trigger = $tree['topics'][$topic]['triggers'][$key];
            $trigger['reply'][] = $line->value();

            $tree['topics'][$topic]['triggers'][$key] = $trigger;

            return ['tree' => $tree];
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
