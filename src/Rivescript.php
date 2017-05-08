<?php

namespace Vulcan\Rivescript;

use Vulcan\Rivescript\Cortex\Input;
use Vulcan\Rivescript\Cortex\Output;

class Rivescript
{
    /**
     * Create a new Rivescript instance.
     */
    public function __construct()
    {
        include 'bootstrap.php';
    }

    /**
     * Load RiveScript documents from files.
     *
     * @param array|string $files
     */
    public function load($files)
    {
        $files = (! is_array($files)) ? (array) $files : $files;

        foreach ($files as $file) {
            synapse()->brain->teach($file);
        }
    }

    public function reply($message, $user = null)
    {
        $input  = new Input($message, $user);
        $output = new Output($input);

        return $output->process();
    }
}
