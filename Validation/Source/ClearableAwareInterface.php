<?php
namespace ImmediateSolutions\Support\Validation\Source;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ClearableAwareInterface
{
    /**
     * @return array
     */
    public function getClearables();

    /**
     * @param array $clearables
     */
    public function setClearables(array $clearables);

    /**
     * @param string $property
     * @return bool
     */
    public function isClearable($property);

    /**
     * @param string $clearable
     */
    public function addClearable($clearable);
}