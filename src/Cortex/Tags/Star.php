<?php

namespace Vulcan\Rivescript\Cortex\Tags;

class Star extends Tag
{
    /**
     * @var array
     */
    protected $allowedSources = ['response'];

    /**
     * Regex expression pattern.
     *
     * @var string
     */
    protected $pattern = '/<star(([0-9])?)>/i';

    /**
     * Parse the response.
     *
     * @param string $response
     * @param array  $data
     *
     * @return array
     */
    public function parse($source)
    {
        if (! $this->sourceAllowed()) {
            return $source;
        }

        if ($this->hasMatches($source)) {
            $matches = $this->getMatches($source);
            $stars   = synapse()->memory->shortTerm()->get('stars');

            foreach ($matches as $key => $match) {
                $needle = $match[0];
                $index  = (empty($match[1]) ? 0 : $match[1] - 1);

                $source = str_replace($match[0], $stars[$index], $source);
            }
        }

        return $source;
    }
}
