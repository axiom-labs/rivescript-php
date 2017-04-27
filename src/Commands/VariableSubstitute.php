<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class VariableSubstitute implements Command
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

            if ($type === 'sub') {
                $value = str_replace('sub', '', $line->value());
                list($sub, $value) = explode('=', $value);

                $sub = trim($sub);
                $value = trim($value);

                $tree['begin']['sub'][$sub] = $value;
            }
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
