<?php

/*
|--------------------------------------------------------------------------
| Create The Synapse
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Synapse connection, which
| will act as the "glue" between the core pieces of the Rivescript
| Interpreter.
|
*/

$synapse = new Vulcan\Rivescript\Cortex\Synapse();

/*
|--------------------------------------------------------------------------
| Bind Important Variables
|--------------------------------------------------------------------------
|
| Next, we will bind some important variables within the synapse so
| we will be able to resolve them when needed.
|
*/

$synapse->commands = Vulcan\Collections\Collection::make(['Trigger', 'Response', 'Variable', 'VariableSubstitute']);
$synapse->triggers = Vulcan\Collections\Collection::make(['Atomic', 'Wildcard']);
$synapse->tags = Vulcan\Collections\Collection::make(['Bot', 'Star']);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Finally, we will bind some important interfaces within the synapse so
| we will be able to resolve them when needed as well.
|
*/

$synapse->memory = new Vulcan\Rivescript\Cortex\Memory();
$synapse->brain = new Vulcan\Rivescript\Cortex\Brain();

/*
|--------------------------------------------------------------------------
| Autload Additional Files
|--------------------------------------------------------------------------
|
| Now we will autoload some files to aid in using the Rivescript
| interpreter.
|
*/

include 'helpers.php';
