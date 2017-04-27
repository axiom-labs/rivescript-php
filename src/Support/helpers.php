<?php

use Vulcan\Rivescript\Support\Logger;
use Vulcan\Rivescript\Support\Str;
use Vulcan\VerbalExpressions\VerbalExpressions;

/*
 * Dump the passed variable(s) and end the script.
 *
 * @param  dynamic  mixed
 * @return void
 */
if (!function_exists('dd')) {
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
    function log_debug($message, array $context = [])
    {
        $logger = new Logger();

        return $logger->debug($message, $context);
    }
}

if (!function_exists('log_warning')) {
    function log_warning($message, array $context = [])
    {
        $logger = new Logger();

        return $logger->warning($message, $context);
    }
}

if (!function_exists('regex')) {
    /**
     * Return a new instance of VerbalExpressions.
     *
     * @return VerbalExpressions
     */
    function regex()
    {
        return new VerbalExpressions();
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
