<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class Trigger implements Command
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
        if ($line->command() === '+') {
            $currentTopic = $tree['metadata']['topic'];

            $trigger = [
                'trigger'   => $line->value(),
                'reply'     => [],
                'condition' => [],
                'redirect'  => null,
                'previous'  => null,
            ];

            if (!isset($tree['topics']['random'])) {
                $tree['topics']['random'] = [
                    'includes' => [],
                    'inherits' => [],
                    'triggers' => [],
                ];
            }

            $tree['topics'][$currentTopic]['triggers'][] = $trigger;
            $key = max(array_keys($tree['topics'][$currentTopic]['triggers']));
            $tree['topics'][$currentTopic]['triggers'][$key]['key'] = $key;
            $tree['metadata']['trigger'] = $tree['topics'][$currentTopic]['triggers'][$key];

            return ['tree' => $tree];
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
