<?php
namespace ImmediateSolutions\Support\Core\Validation;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait ClearableAwareTrait
{
    /**
     * @var array
     */
    private $clearables = [];

    /**
     * @param array $clearables
     */
    public function setClearables(array $clearables)
    {
        $this->clearables = $clearables;
    }

    /**
     * @return array
     */
    public function getClearables()
    {
        return $this->clearables;
    }

    /**
     * @param string $clearable
     */
    public function addClearable($clearable)
    {
        $this->clearables[] = $clearable;
    }

    /**
     * @param string $property
     * @return bool
     */
    public function isClearable($property)
    {
        return in_array($property, $this->clearables, true);
    }
}