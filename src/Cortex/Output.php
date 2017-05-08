<?php

namespace Vulcan\Rivescript\Cortex;

class Output
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Input
     */
    protected $input;

    /**
     * @var string
     */
    protected $output = 'Error: Response could not be determined.';

    /**
     * Create a new Output instance.
     *
     * @param Input $input
     */
    public function __construct(Input $input)
    {
        $this->input = $input;
    }

    /**
     * Process the correct output response by the interpreter.
     *
     * @return mixed
     */
    public function process()
    {
        synapse()->brain->topic()->triggers()->each(function ($data, $trigger) {
            $this->searchTriggers($trigger);

            if ($this->output !== 'Error: Response could not be determined.') {
                return false;
            }
        });

        return $this->output;
    }

    /**
     * Search through available triggers to find a possible match.
     *
     * @param string $trigger
     *
     * @return bool
     */
    protected function searchTriggers($trigger)
    {
        synapse()->triggers->each(function ($class) use ($trigger) {
            $triggerClass = "\\Vulcan\\Rivescript\\Cortex\\Triggers\\$class";
            $triggerClass = new $triggerClass();

            $found = $triggerClass->parse($trigger, $this->input);

            if ($found === true) {
                $this->getResponse($trigger);

                return false;
            }
        });
    }

    /**
     * Fetch a response from the found trigger.
     *
     * @param string $trigger;
     *
     * @return void
     */
    protected function getResponse($trigger)
    {
        $trigger = synapse()->brain->topic()->triggers()->get($trigger);

        if (isset($trigger['redirect'])) {
            return $this->getResponse($trigger['redirect']);
        }

        $key          = array_rand($trigger['responses']);
        $this->output = $this->parseResponse($trigger['responses'][$key]);
    }

    /**
     * Parse the response through the available tags.
     *
     * @param string $response
     *
     * @return string
     */
    protected function parseResponse($response)
    {
        synapse()->tags->each(function ($tag) use (&$response) {
            $class = "\\Vulcan\\Rivescript\\Cortex\\Tags\\$tag";
            $tagClass = new $class();

            $response = $tagClass->parse($response, $this->data);
        });

        return $response;
    }
}
