<?php
namespace ImmediateSolutions\Support\Validation;

use Countable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Value implements Countable
{
    /**
     * @var array
     */
    private $values = [];

    /**
     * @param mixed $value
     */
    public function addOptional($value)
    {
        $this->values[] = [$value, new Force(Force::OPTIONAL)];
    }

    /**
     * @param mixed $value
     */
    public function add($value)
    {
        $this->values[] = [$value, new Force(Force::REQUIRED)];
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        /**
         * @var Force $force
         */
        foreach ($this->values as list($value, $force)){
            if ($value === null && $force->is(Force::REQUIRED)){
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->values[0][0];
    }

    /**
     * @return array
     */
    public function extract()
    {
        $result = [];

        foreach ($this->values as list($value)){
            $result[] = $value;
        }

        return $result;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->values);
    }
}