<?php

namespace Axiom\Rivescript\Cortex\Commands;

use Axiom\Rivescript\Contracts\Command;

class VariableArray implements Command
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

            if ($type === 'array') {
                $value             = str_replace('array', '', $node->value());
                list($key, $value) = explode('=', $value);

                $key   = trim($key);
                $value = trim($value);

                $value = explode(strpos($value, '|') ? '|' : ' ', $value);

                synapse()->memory->arrays()->put($key, $value);
            }
        }
    }
}
