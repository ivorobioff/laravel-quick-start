<?php
namespace ImmediateSolutions\Support\Permissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait OptionsExpectableTrait
{
    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return $this->options;
    }
}