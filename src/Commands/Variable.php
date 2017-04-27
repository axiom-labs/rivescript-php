<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class Variable implements Command
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

            if ($type === 'var') {
                $value = str_replace('var', '', $line->value());
                list($key, $value) = explode('=', $value);

                $key = trim($key);
                $value = trim($value);

                $tree['begin']['var'][$key] = $value;
            }
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
