<?php

namespace Axiom\Rivescript\Cortex\Tags;

use Axiom\Rivescript\Cortex\Input;

class Bot extends Tag
{
    /**
     * @var array
     */
    protected $allowedSources = ['response', 'trigger'];

    /**
     * Regex expression pattern.
     *
     * @var string
     */
    protected $pattern = '/<bot (.+?)>/i';

    /**
     * Parse the source.
     *
     * @param string $source
     *
     * @return string
     */
    public function parse($source, Input $input)
    {
        if (! $this->sourceAllowed()) {
            return $source;
        }

        if ($this->hasMatches($source)) {
            $matches   = $this->getMatches($source);
            $variables = synapse()->memory->variables();

            foreach ($matches as $match) {
                $value = 'undefined';

                if (isset($variables[$match[1]]) == true) {
                    $value = $variables[$match[1]];
                }
                $source = str_replace($match[0], $value , $source);
            }
        }

        return $source;
    }
}
