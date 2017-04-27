<?php

namespace Vulcan\Rivescript\Tags;

use Vulcan\Rivescript\Contracts\Tag;

class Call implements Tag
{
    protected $tree;

    protected $pattern;

    /**
     * Create a new Call instance.
     *
     * @param array $tree
     */
    public function __construct($tree)
    {
        $this->tree = $tree;
        $this->pattern = regex()
            ->find('<call>')
            ->openGroup()
                ->anything()
            ->closeGroup()
            ->then('</call>')
            ->withAnyCase()
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

            $macro = explode(' ', $matches[1]);
            $object = $macro[0];

            unset($macro[0]);

            /** @noinspection PhpUnusedLocalVariableInspection */
            $args = array_values($macro);

            if (isset($this->tree['objects'][$object])) {
                ob_start();
                eval($this->tree['objects'][$object]);

                $replace = ob_get_contents();
                ob_end_clean();
            }

            $search = $matches[0];

            if (isset($replace)) {
                $response = str_replace($search, $replace, $response);
            }
        }

        return [
            'response' => $response,
            'metadata' => isset($metadata) ? $metadata : [],
        ];
    }
}
