<?php

namespace Vulcan\Rivescript\Contracts;

interface Tag
{
    /**
     * Parse the response.
     *
     * @param string $source
     *
     * @return array
     */
    public function parse($source);
}
