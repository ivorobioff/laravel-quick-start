<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

/*
| -------------------------------------------------------------------
| GENERAL USE FUNCTIONS
| -------------------------------------------------------------------
*/

/**
 * Cuts off the specified substring from the beginning of the specified string
 *
 * @param string $string
 * @param string $unwanted
 * @return string
 */
function cut_string_left($string, $unwanted)
{
    if (!starts_with($string, $unwanted)){
        return $string;
    }

    return substr($string, strlen($unwanted));
}

/**
 * Cuts off the specified substring from the end of the specified string
 *
 * @param string $string
 * @param string $unwanted
 * @return string
 */
function cut_string_right($string, $unwanted)
{
    if (!ends_with($string, $unwanted)){
        return $string;
    }

    return substr($string, 0, strlen($string) - strlen($unwanted));
}

if (!function_exists('array_column')) {
    /**
     * This function provides functionality for array_column() to versions of PHP earlier than 5.5. It mimics the functionality of the built-in function in every way.
     *
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array|bool
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}

/**
 * Converts all keys to camel case
 *
 * @param array $data
 * @return array]
 */
function camel_keys(array $data)
{
    $result = [];

    foreach ($data as $key => $value) {
        $result[camel_case($key)] = is_array($value) ? camel_keys($value) : $value;
    }

    return $result;
}

/**
 * @param $query
 * @return array
 */
function parse_url_query($query)
{
    $data = [];

    parse_str($query, $data);

    return $data;
}

/*
| -------------------------------------------------------------------
| ALIASES OF METHODS IN THE "DEBUG" CLASS
| -------------------------------------------------------------------
*/

function pre()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::pre', func_get_args());
}

function pred()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::pred', func_get_args());
}

function vred()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::vred', func_get_args());
}

function vre()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::vre', func_get_args());
}