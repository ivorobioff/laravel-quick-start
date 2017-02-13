<?php
namespace ImmediateSolutions\Support\Validation;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface SourceHandlerInterface
{
    /**
     * @return mixed
     */
    public function getSource();

    /**
     * @param string $property
     * @return mixed
     */
    public function getValue($property);

    /**
     * @param string $property
     * @return bool
     */
    public function hasProperty($property);
}