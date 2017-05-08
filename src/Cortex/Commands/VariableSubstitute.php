<?php

namespace Vulcan\Rivescript\Cortex\Commands;

use Vulcan\Rivescript\Contracts\Command;

class VariableSubstitute implements Command
{
    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */
    public function parse($node, $command)
    {
        if ($node->command() === '!') {
            $type = strtok($node->value(), ' ');

            if ($type === 'sub') {
                $value             = str_replace('sub', '', $node->value());
                list($key, $value) = explode('=', $value);

                $key   = trim($key);
                $key   = '/\b'.preg_quote($key, '/').'\b/'; // Convert the "key" to a regular expression ready format
                $value = trim($value);

                synapse()->memory->substitute()->put($key, $value);
            }
        }
    }
}
