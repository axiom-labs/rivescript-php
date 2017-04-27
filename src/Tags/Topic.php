<?php

namespace Vulcan\Rivescript\Tags;

use Vulcan\Rivescript\Contracts\Tag;

class Topic implements Tag
{
    /**
     * Regex expression pattern.
     *
     * @var string
     */
    public $pattern = '/{\s*topic\s*=\s*(\w+)\s*}/u';

    protected $tree;

    public function __construct($tree)
    {
        $this->tree = $tree;
    }

    /**
     * Parse the response.
     *
     * @param string $response
     * @param array  $data
     *
     * @return array
     */
    public function parse($response, $data)
    {
        preg_match_all($this->pattern, $response, $matches);

        if (!empty($matches[1])) {
            $response = preg_replace($this->pattern, '', $response);
            $metadata['topic'] = $matches[1][0];
        }

        return [
            'response' => $response,
            'metadata' => isset($metadata) ? $metadata : [],
        ];
    }
}
