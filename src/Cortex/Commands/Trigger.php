<?php

namespace Vulcan\Rivescript\Cortex\Commands;

use Vulcan\Collections\Collection;
use Vulcan\Rivescript\Contracts\Command;

class Trigger implements Command
{
    /**
     * Parse the command.
     *
     * @param Node   $node
     * @param string $command
     *
     * @return array
     */
    public function parse($node, $command)
    {
        if ($node->command() === '+') {
            $topic = synapse()->memory->shortTerm()->get('topic') ?: 'random';
            $topic = synapse()->brain->topic($topic);
            $type  = $this->determineTriggerType($node->value());

            $data = [
                'type'      => $type,
                'responses' => [],
            ];

            $topic->triggers->put($node->value(), $data);

            $topic->triggers = $this->sortTriggers($topic->triggers);

            synapse()->memory->shortTerm()->put('trigger', $node->value());
        }
    }

    /**
     * Determine the type of trigger to aid in sorting.
     *
     * @param string $trigger
     *
     * @return string
     */
    protected function determineTriggerType($trigger)
    {
        $wildcards = [
            'alphabetic' => '/_/',
            'numeric'    => '/#/',
            'global'     => '/\*/',
        ];

        foreach ($wildcards as $type => $pattern) {
            if (@preg_match_all($pattern, $trigger, $stars)) {
                return $type;
            }
        }

        return 'atomic';
    }

    /**
     * Sort triggers based on type and word count from
     * largest to smallest.
     *
     * @param Collection $triggers
     *
     * @return Collection
     */
    protected function sortTriggers($triggers)
    {
        $triggers = $this->determineWordCount($triggers);
        $triggers = $this->determineTypeCount($triggers);

        $triggers = $triggers->sort(function ($current, $previous) {
            return ($current['order'] < $previous['order']) ? -1 : 1;
        })->reverse();

        return $triggers;
    }

    protected function determineTypeCount($triggers)
    {
        $triggers = $triggers->each(function ($data, $trigger) use ($triggers) {
            switch ($data['type']) {
                case 'atomic':
                    $data['order'] += 400;
                    break;
                case 'alphabetic':
                    $data['order'] += 300;
                    break;
                case 'numeric':
                    $data['order'] += 200;
                    break;
                case 'global':
                    $data['order'] += 100;
                    break;
            }

            $triggers->put($trigger, $data);
        });

        return $triggers;
    }

    /**
     * Sort triggers based on word count from
     * largest to smallest.
     *
     * @param Collection $triggers
     *
     * @return Collection
     */
    protected function determineWordCount($triggers)
    {
        $triggers = $triggers->each(function ($data, $trigger) use ($triggers) {
            $data['order'] = count(explode(' ', $trigger));

            $triggers->put($trigger, $data);
        });

        return $triggers;
    }
}
