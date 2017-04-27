<?php

namespace Vulcan\Rivescript\Triggers;

use Vulcan\Rivescript\Contracts\Trigger;

class Wildcard implements Trigger
{
    protected $replacements = [
        [
            'pattern'     => '/^\*$/',
            'replacement' => '<zerowidthstar>',
        ],
        [
            'pattern'     => '/\*/',
            'replacement' => '.+?',
        ],
        [
            'pattern'     => '/#/',
            'replacement' => '\\d+?',
        ],
        [
            'pattern'     => '/_/',
            'replacement' => '\\w+?',
        ],
        [
            'pattern'     => '/<zerowidthstar>/',
            'replacement' => '.*?',
        ],
    ];

    /**
     * Parse the trigger.
     *
     * @param int    $key
     * @param string $trigger
     * @param string $message
     *
     * @return array
     */
    public function parse($key, $trigger, $message)
    {
        foreach ($this->replacements as $replacement) {
            $parsedTrigger = preg_replace($replacement['pattern'], '('.$replacement['replacement'].')', $trigger);

            if (@preg_match('#^'.$parsedTrigger.'$#u', $message, $stars)) {
                array_shift($stars);

                return [
                    'match' => true,
                    'key'   => $key,
                    'data'  => ['stars' => $stars],
                ];
            }
        }

        return ['match' => false];
    }
}
