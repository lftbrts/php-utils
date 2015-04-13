<?php
namespace Ideaworks\Utils;

/**
 * @author Ulf Tiburtius <ulf@idea-works.de>
 * @since April 12, 2015
 */
class Str
{

    /**
     * Determine if a string is equal to a reversed string.
     *
     * @param string $str1
     * @param string $str2
     * @param boolean $casesensitive defaults to TRUE
     * @return boolean
     */
    public static function areEqualReverse($str1, $str2, $casesensitive = true)
    {
        if ($casesensitive) {
            return ($str1 === strrev($str2));
        }
        return (strtolower($str1) === strrev(strtolower($str2)));
    }

    /**
     * Determine if two strings are equal.
     *
     * @param string $str1
     * @param string $str2
     * @param boolean $casesensitiv defaults to TRUE
     * @return boolen
     */
    public static function areEqual($str1, $str2, $casesensitiv = true)
    {
        if ($casesensitiv) {
            return ($str1 === $str2);
        }
        return (strtolower($str1) === strtolower($str2));
    }

    /**
     * Check whether a string contains at least one NULL byte.
     *
     * @param string $str
     * @return boolean
     */
    public static function containsNullByte($str)
    {
        if (strpos($str, chr(0)) === false) {
            return false;
        }
        return true;
    }

    /**
     * Check whether a string is smaller or equal a given length.
     *
     * @param string $str
     * @param integer $length
     * @return boolean TRUE if its smaller or equal to given length, FALSE if not
     */
    public static function maxLength($str, $length)
    {
        return (strlen((string) $str) <= $length);
    }

    /**
     * Check whether a string is larger or equal a given length.
     *
     * @param string $str
     * @param integer $length
     * @return boolean TRUE if its larger or equal to given length, FALSE if not
     */
    public static function minLength($str, $length)
    {
        return (strlen((string) $str) >= $length);
    }

    /**
     * Determine if a string is empty or contains only white spaces.
     *
     * @param string $str
     * @return boolean
     */
    public static function isEmpty($str)
    {
        if (! isset($str)) {
            return true;
        } elseif (preg_match('/^\s*$/', $str)) {
            return true;
        } else {
            return false;
        }
    }
}
