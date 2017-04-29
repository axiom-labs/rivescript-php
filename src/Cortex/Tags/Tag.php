<?php

namespace Vulcan\Rivescript\Cortex\Tags;

use LogicException;
use Vulcan\Rivescript\Contracts\Tag as TagContract;

abstract class Tag implements TagContract
{
    /**
     * @var string
     */
    protected $sourceType;

    /**
     * Create a new Tag instance.
     *
     * @param string $sourceType
     */
    final public function __construct($sourceType = 'response')
    {
        $this->sourceType = $sourceType;

        if (!isset($this->allowedSources)) {
            throw new LogicException(get_class($this).' must have an "allowedSources" property declared.');
        }
    }

    /**
     * Determine if the type of source is allowed.
     *
     * @return bool
     */
    public function sourceAllowed()
    {
        return in_array($this->sourceType, $this->allowedSources);
    }

    /**
     * Does the source have any matches?
     *
     * @param string $source
     *
     * @return bool
     */
    protected function hasMatches($source)
    {
        preg_match_all($this->pattern, $source, $matches);

        return isset($matches[0][0]);
    }

    /**
     * Get the regular expression matches from the source.
     *
     * @param string $source
     *
     * @return array
     */
    protected function getMatches($source)
    {
        if ($this->hasMatches($source)) {
            preg_match_all($this->pattern, $source, $matches, PREG_SET_ORDER);

            return $matches;
        }
    }
}
