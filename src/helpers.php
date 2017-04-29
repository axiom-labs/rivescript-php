<?php

use Vulcan\Rivescript\Cortex\Synapse;
use Vulcan\Rivescript\Support\Logger;
use Vulcan\Rivescript\Support\Str;

if (!function_exists('synapse')) {
    /**
     * Get the available Synapse instance.
     *
     * @return Synapse
     */
    function synapse()
    {
        return Synapse::getInstance();
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variable(s) and end the script.
     *
     * @param  dynamic  mixed
     *
     * @return void
     */
    function dd()
    {
        array_map(function ($x) {
            print_r($x);
            echo"\n";
        }, func_get_args());
        die;
    }
}

if (!function_exists('ends_with')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    function ends_with($haystack, $needle)
    {
        return Str::endsWith($haystack, $needle);
    }
}

if (!function_exists('log_debug')) {
    /**
     * Log the message and contextual array as a new debug entry.
     *
     * @param string $message
     * @param array  $context
     *
     * @return Logger
     */
    function log_debug($message, array $context = [])
    {
        $logger = new Logger();

        return $logger->debug($message, $context);
    }
}

if (!function_exists('log_warning')) {
    /**
     * Log the message and contextual array as a new warning entry.
     *
     * @param string $message
     * @param array  $context
     *
     * @return Logger
     */
    function log_warning($message, array $context = [])
    {
        $logger = new Logger();

        return $logger->warning($message, $context);
    }
}

if (!function_exists('remove_whitespace')) {
    /**
     * Trim leading and trailing whitespace as well as
     * whitespace surrounding individual arguments.
     *
     * @param string $line
     *
     * @return string
     */
    function remove_whitespace($line)
    {
        return Str::removeWhitespace($line);
    }
}

if (!function_exists('starts_with')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    function starts_with($haystack, $needle)
    {
        return Str::startsWith($haystack, $needle);
    }
}
