<?php
namespace ImmediateSolutions\Support\Validation\Rules;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait WithSpacesTrait
{
    /**
     * @var bool
     */
    private $withSpaces = false;

    /**
     * @param bool $flag
     * @return $this
     */
    public function withSpaces($flag)
    {
        $this->withSpaces = $flag;
        return $this;
    }

    /**
     * @param string $pattern
     * @return string
     */
    public function applySpaces($pattern)
    {
        if (!$this->withSpaces){
            return $pattern;
        }

        return $pattern.' ';
    }
}