<?php
namespace ImmediateSolutions\Support\Validation;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface RuleInterface
{
    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value);

    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return bool
     */
    public function isNullable();
}