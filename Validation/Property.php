<?php
namespace ImmediateSolutions\Support\Validation;

use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Property
{
    /**
     * @var RuleInterface[]
     */
    private $rules = [];

    /**
     * @param RuleInterface $rule
     * @return Property
     * @throws RuntimeException
     */
    public function addRule(RuleInterface $rule)
    {
        $identifier = strtolower($rule->getIdentifier());

        if (isset($this->rules[$identifier])){
            throw new RuntimeException('Rule with the "'.$identifier.'" identifier has been already added.');
        }

        $this->rules[$identifier] = $rule;

        return $this;
    }

    /**
     * @return RuleInterface[]
     */
    public function getRules()
    {
        return $this->rules;
    }
}