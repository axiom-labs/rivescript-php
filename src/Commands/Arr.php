<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class Arr implements Command
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

            if ($type === 'array') {
                $value = str_replace('array', '', $line->value());
                list($key, $values) = explode('=', $value);

                $key = trim($key);

                // Explode by pipe symbol first
                $explodedValues = explode('|', $values);

                // If no pipe symbols were used, explode by spaces
                if (count($explodedValues) <= 1) {
                    $explodedValues = explode(' ', $values);
                }

                // Replace the string "\s" with spaces
                foreach ($explodedValues as $index => $value) {
                    $value = str_replace('/s', ' ', $value);
                    $value = trim($value);

                    if (!empty($value)) {
                        $explodedValues[$index] = $value;
                    } else {
                        unset($explodedValues[$index]);
                    }
                }

                // Store values
                $tree['begin']['array'][$key] = $explodedValues;
            }
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
