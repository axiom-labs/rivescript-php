<?php

namespace Vulcan\Rivescript\Support;

class Str
{
    /**
     * Trim leading and trailing whitespace as well as
     * whitespace surrounding individual arguments.
     *
     * @param string $line
     *
     * @return string
     */
    public static function removeWhitespace($line)
    {
        return preg_replace('/[\pC\pZ]+/u', ' ', trim($line));
    }

    /**
     * Determine if string starts with the supplied needle.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        return $needle === '' or mb_strrpos($haystack, $needle, -mb_strlen($haystack)) !== false;
    }

    /**
     * Determine if string ends with the supplied needle.
     *
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        return $needle === '' or (($temp = mb_strlen($haystack) - mb_strlen($needle)) >= 0 and mb_strpos($haystack, $needle, $temp) !== false);
    }
}
