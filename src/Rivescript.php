<?php

namespace Vulcan\Rivescript;

class Rivescript
{
    /**
     * @var Parser
     */
    protected $parser;

    public $tree = null;

    protected $metadata = [
        'topic' => 'random',
    ];

    protected $tags = [
        'Topic',
        'Star',
        'Call',
        'Bot',
    ];

    protected $triggers = [
        'Arr',
        'Atomic',
        'Wildcard',
    ];

    /**
     * Create a new Rivescript instance.
     */
    public function __construct()
    {
        $this->parser = new Parser();
    }

    /*
    |--------------------------------------------------------------------------
    | Loading and Parsing Methods
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Load a RiveScript document from a file.
     *
     * @param array|string $files
     */
    public function load($files)
    {
        $files = (!is_array($files)) ? (array) $files : $files;

        foreach ($files as $file) {
            $this->tree = $this->parser->process($file, $this->tree);
        }
    }

    public function reply($user, $message)
    {
        $message = $this->prepareMessage($message);

        $this->storeInput($message);

        $triggers = $this->tree['topics'][$this->getMetadata('topic')]['triggers'];

        if (count($triggers) > 0) {
            foreach ($triggers as $key => $trigger) {
                foreach ($this->triggers as $class) {
                    $triggerClass = "\\Vulcan\\Rivescript\\Triggers\\$class";
                    $triggerClass = new $triggerClass();

                    $found = $triggerClass->parse($key, $trigger['trigger'], $message);

                    if (isset($found['match']) and $found['match'] === true) {
                        log_debug('Found match', [
                            'type'    => $class,
                            'message' => $message,
                            'found'   => $found,
                        ]);

                        break 2;
                    }
                }
            }

            if (isset($found['key']) and is_int($found['key'])) {
                $replies = $triggers[$found['key']]['reply'];

                if (isset($triggers[$found['key']]['redirect'])) {
                    $message = $this->parseReply($triggers[$found['key']]['redirect'], $found['data']);

                    return $this->reply($user, $message);
                }

                if (count($replies)) {
                    $key = array_rand($replies);
                    $reply = $this->parseReply($replies[$key], $found['data']);

                    return $reply;
                }
            }
        }

        return 'No response found.';
    }

    public function parseReply($message, $data = [])
    {
        $message = [
            'response' => $message,
            'metadata' => [],
        ];

        foreach ($this->tags as $class) {
            $class = "\\Vulcan\\Rivescript\\Tags\\$class";
            /** @var \Vulcan\Rivescript\Contracts\Tag $tagClass */
            $tagClass = new $class($this->tree);

            $message = $tagClass->parse($message['response'], $data);

            $this->syncMetadata($message['metadata']);
        }

        $this->storeReply($message['response']);

        return $message['response'];
    }

    public function syncMetadata($collection)
    {
        foreach ($collection as $key => $value) {
            $this->setMetadata($key, $value);
        }
    }

    public function getMetadata($key)
    {
        return $this->metadata[$key];
    }

    public function setMetadata($key, $value)
    {
        $this->metadata[$key] = $value;
    }

    protected function prepareMessage($message)
    {
        $message = mb_strtolower($message);

        foreach ($this->tree['begin']['sub'] as $find => $replace) {
            $message = str_replace($find, $replace, $message);
        }

        $message = remove_whitespace($message);
        $message = preg_replace('/[^\pL\d\s]+/u', '', $message);

        return $message;
    }

    protected function storeInput($message)
    {
        $input = $this->tree['metadata']['input'];

        array_unshift($input, $message);
        array_slice($input, 0, 9);

        $this->tree['metadata']['input'] = $input;

        log_debug('Storing input', ['message' => $message, 'inputs' => $input]);
    }

    protected function storeReply($message)
    {
        $reply = $this->tree['metadata']['reply'];

        array_unshift($reply, $message);
        array_slice($reply, 0, 9);

        $this->tree['metadata']['reply'] = $reply;

        log_debug('Storing reply', ['message' => $message, 'replies' => $reply]);
    }
}
