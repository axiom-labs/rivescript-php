<?php

namespace Vulcan\Rivescript\Commands;

use Vulcan\Rivescript\Contracts\Command;

class ObjectMacro implements Command
{
    public function parse($tree, $line, $command)
    {
        if ($line->command() === '>') {
            if (count(explode(' ', $line->value())) === 3) {
                list($type, $method, $language) = explode(' ', $line->value());

                if ($type === 'object' and $language === 'php') {
                    $tree['metadata']['object'] = [
                        'name'  => $method,
                        'code'  => [],
                    ];
                }
            }
        } elseif ($line->command() === '<') {
            list($type) = explode(' ', $line->value());

            if ($type === 'object') {
                $name = $tree['metadata']['object']['name'];
                $code = $tree['metadata']['object']['code'];

                $tree['objects'][$name] = implode("\n", $code);

                $tree['metadata']['object'] = null;
            }
        } elseif (!is_null($tree['metadata']['object'])) {
            $code = $line->command().$line->value();
            $tree['metadata']['object']['code'][] = $code;
        }

        return [
            'command' => $command,
            'tree'    => $tree,
        ];
    }
}
