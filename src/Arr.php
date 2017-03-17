<?php
namespace lftbrts\Utils;

/**
 * @author Ulf Tiburtius <ulf@idea-works.de>
 * @since April 12, 2015
 */
class Arr
{
    /**
     * Determine if an array is associative.
     *
     * @param array $array
     *
     * @return boolean
     */
    public static function array_is_assoc(array $array) {
        return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
    }

    /**
     * Remove key(s) from an array.
     *
     * @param array Array from which the key(s) should be removed.
     * @param mixed Key(s) to remove from array
     *
     * @return array
     * @example $result = Arr::array_remove_key($arr, 0, 1, 'foo');
     */
    public static function array_remove_key()
    {
        $args = func_get_args();
        return array_diff_key($args[0], array_flip(array_slice($args, 1)));
    }

    /**
     * Change a key of an associative array.
     *
     * @param array $array
     * @param string $oldKey
     * @param string $newKey
     *
     * @return array
     */
    public static function array_change_key(array $array, $oldKey, $newKey)
    {
        if (!array_key_exists($oldKey, $array) || !self::array_is_assoc($array)) {
            return $array;
        }

        $keys = array_keys($array);
        $keys[array_search($oldKey, $keys, false)] = $newKey;

        return array_combine($keys, $array);
    }

    /**
     * Check if an associative array contains certain keys.
     * Searches haystack for needle.
     *
     * @param array $needle
     * @param array $haystack
     *
     * @return boolean
     */
    public static function array_contain_keys(array $needle, array $haystack)
    {
        return (count(array_intersect_key(array_flip($needle), $haystack)) === count($needle));
    }

    /**
     * Remove value(s) from an array.
     *
     * @example $result = Arr::array_remove_value($arr, 'foo', 'baz');
     * @param array Array from which the value(s) should be removed.
     * @param mixed Value(s) to remove from array
     *
     * @return array
     * @example $result = Arr::array_remove_value($arr, 'bear');
     */
    public static function array_remove_value()
    {
        $args = func_get_args();
        return array_diff($args[0], array_slice($args, 1));
    }

    /**
     * Remove all empty values from an array.
     *
     * @param array
     *
     * @return array
     * @example $result = Arr::array_remove_empty_value($arr);
     */
    public static function array_remove_empty_value()
    {
        $args = func_get_args();
        $array = [];
        if (!empty($args)) {
            $array = $args[0];
            if (!empty($array) || is_array($array)) {
                // The fastest way in PHP: faster then array_diff() or array_filter()
                $emptyElements = array_keys($array, '');
                foreach ($emptyElements as $element) {
                    unset($array[$element]);
                }
            }
        }
        return $array;
    }

    /**
     * Search for the structure by a given value on a multidimensional array.
     * This will break execution on the first occurrence of the matched value.
     *
     * @param mixed $needle
     * @param array $haystack
     * @param array $keys
     *
     * @return array|false
     * @example $keys = array_walkup(3, $arr); echo "3 has been found in \$arr[".implode('][', $keys)."]";
     */
    public static function array_walkup($needle, array $haystack, array $keys = array())
    {
        if (true === in_array($needle, $haystack, false)) {
            $keys[] = array_search($needle, $haystack, false);
            return $keys;
        }
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $k = $keys;
                $k[] = $key;
                if (($find = self::array_walkup($needle, $value, $k)) !== false) {
                    return $find;
                }
            }
        }
        return false;
    }

    /**
     * Reverses the order of an array group-wise.
     *
     * @param array $arr
     * @param integer $set
     *
     * @return array
     */
    public static function array_reverse_sets(array $arr = [], $set = 0)
    {
        if (!is_array($arr) || count($arr) % $set !== 0) {
            return $arr;
        }
        $result = [];
        for($i = 0, $iMax = count($arr); $i < $iMax; $i += $set) {
            for($j = 0; $j < $set; $j++) {
                $result[] = $arr[count($arr) - $i + $j - $set];
            }
        }
        return $result;
    }

}
