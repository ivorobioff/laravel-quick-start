<?php
namespace ImmediateSolutions\Support\Debugging;

use IteratorAggregate;
use Iterator;

/**
 * Contains some useful methods for debuggin purposes
 *
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Debug
{
    public static function pre()
    {
        static::dump(func_get_args(), true);
    }

    public static function vre()
    {
        static::dump(func_get_args());
    }

    public static function pred()
    {
        static::dump(func_get_args(), true);
        die;
    }

    public static function vred()
    {
        static::dump(func_get_args());
        die;
    }

    private static function dump(array $args, $print_r = false)
    {
        foreach ($args as $arg) {
            echo '<pre>';
            if ($arg instanceof Iterator || $arg instanceof IteratorAggregate) {
                $data = iterator_to_array($arg);
                if ($print_r) {
                    print_r($data);
                } else {
                    var_dump($data);
                }
            } else {
                if ($print_r) {
                    print_r($arg);
                } else {
                    var_dump($arg);
                }
            }
            echo '</pre>';
        }
    }
}