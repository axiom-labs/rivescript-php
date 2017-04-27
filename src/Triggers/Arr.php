<?php

namespace Vulcan\Rivescript\Triggers;

use Vulcan\Rivescript\Contracts\Trigger;
use Vulcan\VerbalExpressions\VerbalExpressions;

class Arr implements Trigger
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
        $regex = new VerbalExpressions();

        $regex->find('@')->anythingBut(' ');

        $pattern = $regex->getRegex();

        @preg_match_all($pattern, $trigger, $array);
        // dd($pattern, $trigger, $array);
        //
        // if (! empty($array[0])) {
        //     dd($array);
        // }

        return ['match' => false];
    }
}
