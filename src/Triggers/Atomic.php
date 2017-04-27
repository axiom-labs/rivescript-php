<?php

namespace Vulcan\Rivescript\Triggers;

use Vulcan\Rivescript\Contracts\Trigger;

class Atomic implements Trigger
{
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
        if ($trigger === $message) {
            return [
                'match' => true,
                'key'   => $key,
                'data'  => [],
            ];
        }

        return ['match' => false];
    }
}
