<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class Topic implements Command
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
        if ($line->command() === '>') {
            list($type, $topic) = explode(' ', $line->value());

            if ($type === 'topic') {
                $tree['metadata']['topic'] = $topic;
            }
        }

        if ($line->command() === '<') {
            $tree['metadata']['topic'] = 'random';
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
