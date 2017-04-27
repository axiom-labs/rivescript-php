<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class VariablePerson implements Command
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
        if ($line->command() === '!') {
            $type = strtok($line->value(), ' ');

            if ($type === 'person') {
                $value = str_replace('person', '', $line->value());
                list($key, $value) = explode('=', $value);

                $key = trim($key);
                $value = trim($value);

                $tree['begin']['person'][$key] = $value;
            }
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
