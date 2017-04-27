<?php

namespace Vulcan\Rivescript\Tags;

use Vulcan\Rivescript\Contracts\Tag;

class Bot implements Tag
{
    /**
     * @var array
     */
    protected $tree;

    protected $pattern;

    /**
     * Create a new Bot instance.
     *
     * @param array $tree
     */
    public function __construct($tree)
    {
        $this->tree = $tree;
        $this->pattern = regex()
            ->find('<bot ')
            ->openGroup()
                ->anythingBut('>')
            ->closeGroup()
            ->then('>')
            ->stopAtFirst();
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
        if ($this->pattern->test($response)) {
            $matches = $this->pattern->match($response);

            $response = $this->pattern->replace($response, $this->tree['begin']['var'][$matches[1]]);
        }

        return [
            'response' => $response,
            'metadata' => isset($metadata) ? $metadata : [],
        ];
    }
}
