<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Error;
use Traversable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Collection extends AbstractRule
{
    /**
     * @var bool
     */
    private $isSimple;

    /**
     * @param bool $isSimple
     */
    public function __construct($isSimple = true)
    {
        $this->isSimple = $isSimple;

        $this->setIdentifier('cast')
            ->setMessage('The value must be a collection.');
    }

    /**
     * @param mixed $collection
     * @return Error|null
     */
    public function check($collection)
    {
        if (!is_array($collection) && !$collection instanceof Traversable){
            return $this->getError();
        }

        $next = 0;

        foreach ($collection as $key => $value) {

            if ($this->isSimple && !is_scalar($value) && $value !== null) {
                return $this->getError();
            }

            if ($key !== $next) {
                return $this->getError();
            }

            $next++;
        }

        return null;
    }
}