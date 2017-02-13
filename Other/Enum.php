<?php
namespace ImmediateSolutions\Support\Other;

use UnexpectedValueException;
use ReflectionClass;

/**
 * Emulates enumeration objects in PHP
 *
 * @usage:
 *
 * Let's say we defined the following class:
 *
 * class Colors extends Enum
 * {
 *     const RED = 1;
 *     const GREEN = 2;
 *     const BLUE = 3;
 *     const YELLOW = 4;
 * }
 *
 * Now, this is how it can be used
 *
 * $color = new Colors(Colors::BLUE); - This will work
 * $color = new Colors('3'); - This will throw an error
 * $color = new Colors(3) - This will work
 *
 * Use to check the value
 * if ($color->is(Colors::GREEN))
 * {
 *     echo "It's green";
 * }
 *
 * if ($color->is([Colors::GREEN, Colors::RED]))
 * {
 *    echo "It's green/red";
 * }
 *
 * $color =  $color->value(); - Use to get the value
 * $colors = Colors::toArray(); - Use to get all values
 * $colors = Colors::toObjects(); - Use to get all values as Enum objects
 *
 * Use to check if enum has value
 * Colors::has('3'); - will return "true"
 * Colors::has(3); - will return "true"
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Enum
{
    /**
     * @var array
     */
    private static $constantsCache = [];

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     * @throws UnexpectedValueException
     */
    public function __construct($value)
    {
        if (!self::has($value)) {
            throw new UnexpectedValueException('Value "'.$value.'" is not part of the enum ' . get_called_class());
        }

        $this->value = $value;
    }

    /**
     * @param mixed|array $value
     * @return bool
     */
    public function is($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        return in_array($this->value, $value, true);
    }

    /**
     * @param Enum $enum
     * @return bool
     */
    public function isEqual(Enum $enum)
    {
        return $this->is($enum->value());
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function has($value)
    {
        return in_array($value, self::toArray(), true);
    }

    /**
     * @return array
     */
    public static function toArray()
    {
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constantsCache)) {
            $reflection = new ReflectionClass($calledClass);
            self::$constantsCache[$calledClass] = $reflection->getConstants();
        }
        return self::$constantsCache[$calledClass];
    }

    /**
     * Returns array of enum objects
     *
     * @return static[]
     */
    public static function toObjects()
    {
        $objects = [];

        foreach (static::toArray() as $value) {
            $objects[] = new static($value);
        }

        return $objects;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value();
    }
}