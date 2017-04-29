<?php

namespace Vulcan\Rivescript\Contracts;

interface Command
{
    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */
    public function parse($node, $command);
}
