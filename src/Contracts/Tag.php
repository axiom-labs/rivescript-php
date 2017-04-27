<?php

namespace Vulcan\Rivescript\Contracts;

interface Tag
{
    /**
     * Parse the response.
     *
     * @param string $response
     * @param array  $data
     *
     * @return array
     */
    public function parse($response, $data);
}
