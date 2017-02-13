<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;

class Enum extends AbstractRule
{
    /**
     * @var string
     */
    private $enum;

    /**
     * @param string $enum
     */
    public function __construct($enum)
    {
        $this->enum = $enum;

        $this->setIdentifier('cast');

        $message = 'The provided value must be one of the following values: '
            .implode(', ', call_user_func([$this->enum, 'toArray']));

        $this->setMessage($message);
    }

    /**
     * @param string $values
     * @return Error|null
     */
    public function check($values)
    {
		if (!is_array($values)){
			$values = [$values];
		}

		foreach ($values as $value){
			if (!call_user_func([$this->enum, 'has'], $value)) {
				return $this->getError();
			}
		}

        return null;
    }
}
