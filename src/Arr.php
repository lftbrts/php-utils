<?php
namespace Ideaworks\Utils;

/**
 *
 * @author Ulf Tiburtius <ulf@idea-works.de>
 * @since April 12, 2015
 */
class Arr
{

    /**
	 * @param array $array
	 * @return boolean
	 */
	public static function array_is_assoc(array $array) {
		return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
	}

    /**
     *
     * @param array Array from which the key(s) should be removed.
     * @param mixed Key(s) to remove from array
     * @return array
     */
    public static function array_remove_key()
    {
        $args = func_get_args();
        return array_diff_key($args[0], array_flip(array_slice($args, 1)));
    }

    /**
     *
     * @param array Array from which the value(s) should be removed.
     * @param mixed Value(s) to remove from array
     * @return array
     */
    public static function array_remove_value()
    {
        $args = func_get_args();
        return array_diff($args[0], array_slice($args, 1));
    }

    /**
     * Remove all empty values of an array.
     *
     * @param array Array from which the empty values should be removed
     * @return array
     */
    public static function array_remove_empty_value()
    {
        $args = func_get_args();
        $array = array();
        if (!empty($args)) {
            $array = $args[0];
            if (!empty($array) || true == is_array($array)) {
                // The fastest way in PHP: faster then array_diff() or array_filter()
                $emptyelements = array_keys($array, '');
                foreach ($emptyelements as $element) {
                    unset($array[$element]);
                }
            }
        }
        return $array;
    }

    /**
     * Search for the structure by a given value on a multidimensional array.
     * This will break execution on the first occurrence of the matched value.
     * @Example $keys = array_walkup(3, $arr); echo "3 has been found in \$arr[".implode('][', $keys)."]";
     *
     * @param mixed $needle
     * @param array $array
     * @param array $keys
     * @return array|false
     */
    public static function array_walkup($needle, array $haystack, array $keys = array())
    {
        if (true == in_array($needle, $haystack)) {
            array_push($keys, array_search($needle, $haystack));
            return $keys;
        }
        foreach ($haystack as $key => $value) {
            if (true == is_array($value)) {
                $k = $keys;
                $k[] = $key;
                if (($find = self::array_walkup($needle, $value, $k)) !== false) {
                    return $find;
                }
            }
        }
        return false;
    }

}
