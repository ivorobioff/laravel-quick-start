<?php
namespace ImmediateSolutions\Support\Api\Verify;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Action
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param string|string[] $names
     * @return bool
     */
    public function is($names)
    {
        if (!is_array($names)){
            $names = [$names];
        }

        return in_array($this->name, $names);
    }
}